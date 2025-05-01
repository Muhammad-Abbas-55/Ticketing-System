<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class LabelController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $labels = Label::select(['id', 'name', 'created_at']);
            return DataTables::of($labels)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('Y-m-d') : '';
                })
                ->make(true);
        }
        return view('labels.index');
    }

    public function create()
    {
        return view('labels.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:labels|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Label::create([
            'name' => $request->name,
        ]);

        return response()->json(['success' => 'Label created successfully!']);
    }

    public function edit(Label $label)
    {
        return view('labels.edit', compact('label'));
    }

    public function update(Label $label, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:labels,name,' . $label->id . '|min:3',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $label->name = $request->name;
        $label->save();
        return response()->json(['success' => 'Label updated successfully!']);
    }

    public function destroy(Label $label)
    {
        try {
            $label->delete();
            return response()->json(['success' => 'Label Deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => 'Some problem occure'], 500);
        }
    }
}

