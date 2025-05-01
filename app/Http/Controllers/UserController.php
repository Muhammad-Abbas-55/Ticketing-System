<?php

namespace App\Http\Controllers;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{

    public static function middleware():array
    {
        return[
            new Middleware('permission:view users', only: ['index']),
            new Middleware('permission:edit users', only: ['edit']),
            new Middleware('permission:delete users', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::latest()->select(['id', 'name', 'email', 'created_at']);
    
            return DataTables::of($query)
                // 1. Add a serial number column
                ->addIndexColumn()
                
                // 2. Format the created_at value
                ->editColumn('created_at', function (User $user) {
                    return $user->created_at->format('d, M, Y');
                })
                ->editColumn('roles', fn(User $u) => $u->roles->pluck('name')->join(', '))
                ->make(true);
        }
    
        return view('users.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user)
    {
        $user = User::findOrFail($user);
        // it checked the assigned roles
        $hasRoles = $user->roles->pluck('id');
        // dd($hasRoles);
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'hasRoles' => $hasRoles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // assign roles to user
        $user->syncRoles($request->role);

        return response()->json(['success' => 'User updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(['success' => 'User Deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => 'Some problem occure'], 500);
        }
    }
}
