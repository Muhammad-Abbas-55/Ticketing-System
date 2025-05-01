<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Label;
use App\Models\Category;
use App\Models\TicketLog;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketCreatedMail;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use Illuminate\Support\Facades\Log;

class TicketController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view tickets', only: ['index']),
            new Middleware('permission:edit tickets', only: ['edit']),
            new Middleware('permission:create tickets', only: ['create']),
            new Middleware('permission:delete tickets', only: ['destroy']),
        ];
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Ticket::with(['user', 'labels', 'categories'])->latest();

            // Filter: If the user has 'user' role, only show their own tickets
            if (auth()->user()->hasRole('user')) {
                $query->where('user_id', auth()->id());
            }

            if (auth()->user()->hasRole('agent')) {
                $query->where('agent_id', auth()->id());
            }

            return DataTables::of($query->select('tickets.*'))
                // 1. Add a serial number column
                ->addIndexColumn()
                ->editColumn('user', fn($ticket) => $ticket->user->name ?? 'N/A')
                // 2. Format the labels name many
                ->editColumn('labels', fn($ticket) => $ticket->labels->pluck('name')->join(', '))
                ->editColumn('categories', fn($ticket) => $ticket->categories->pluck('name')->join(', '))
                // 3. Format the created_at value
                ->editColumn('created_at', fn($ticket) => $ticket->created_at->format('d M Y'))
                ->make(true);
        }

        return view('tickets.index');
    }

    public function create()
    {
        $labels = Label::all();
        $categories = Category::all();
        return view('tickets.create', compact('labels', 'categories'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'priority' => 'required|string',
            'labels' => 'nullable|array',
            'categories' => 'nullable|array',
            'uploaded_image_path' => 'nullable|string',
        ]);

        $ticket = new Ticket();
        $ticket->fill($validated);
        $ticket->user_id = auth()->id();

        if (!empty($validated['uploaded_image_path'])) {
            $ticket->image = $validated['uploaded_image_path'];
        }

        $ticket->save();

        if (!empty($validated['labels'])) {
            $ticket->labels()->sync($validated['labels']);
        }

        if (!empty($validated['categories'])) {
            $ticket->categories()->sync($validated['categories']);
        }

        TicketLog::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'action' => 'created',
            'changes' => json_encode(['new' => $ticket->fresh()->toArray()]),
        ]);

        // Send email to all admins
        $admins = User::role('admin')->get();
        try {
            foreach ($admins as $admin) {
                // Mail::to('abbas.alvi.5555@gmail.com')->send(new TicketCreatedMail($ticket));
                Mail::to($admin->email)->send(new TicketCreatedMail($ticket));
                Log::info('Ticket email sent  to ' . $admin->email);
            }
        } catch (\Exception $e) {
            Log::error('Ticket email failed: ' . $e->getMessage());
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Ticket Created',
                'message' => 'Ticket created successfully!',
                'ticket_id' => $ticket->id,
            ]);
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }



    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('ticket_image'), $filename);

            return response()->json([
                'path' => 'ticket_image/' . $filename
            ]);
        }

        return response()->json(['message' => 'No file uploaded.'], 422);
    }

    public function show(Ticket $ticket)
    {
        // Load relationships like labels and categories if you need them
        $ticket->load(['user', 'labels', 'categories']);

        // Return the view with the ticket data
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $labels = Label::all();
        $categories = Category::all();
        $agents = User::role('agent')->get(); // assuming spatie/laravel-permission
        return view('tickets.edit', compact('ticket', 'labels', 'categories', 'agents'));
    }


    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'priority' => 'required|string',
            'labels' => 'required|array',
            'categories' => 'required|array',
            'agent_id' => 'nullable|exists:users,id',
            'comment' => 'nullable|string',
            'uploaded_image_path' => 'nullable|string|max:255',
        ]);

        $oldData = $ticket->toArray();

        if (!empty($validated['uploaded_image_path'])) {
            // Delete old image
            if ($ticket->image && file_exists(public_path($ticket->image))) {
                unlink(public_path($ticket->image));
            }

            // Save new uploaded image
            $ticket->image = $validated['uploaded_image_path'];
        }


        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'priority' => $validated['priority'],
            'comment' => $validated['comment'],
        ];

        if (auth()->user()->hasAnyRole(['admin', 'super admin'])) {
            $data['agent_id'] = $request->agent_id;
        }

        $ticket->update($data);
        $ticket->labels()->sync($validated['labels']);
        $ticket->categories()->sync($validated['categories']);

        $newData = $ticket->fresh()->toArray();

        TicketLog::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'action' => 'updated',
            'changes' => json_encode([
                'old' => $oldData,
                'new' => $newData,
            ]),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Ticket Updated',
                'message' => 'Ticket updated successfully!',
                'ticket_id' => $ticket->id,
            ]);
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }



    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response()->json(['message' => 'Ticket deleted']);
    }
}
