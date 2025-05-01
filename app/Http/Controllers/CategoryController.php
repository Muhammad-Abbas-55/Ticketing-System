<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::select(['id', 'name', 'created_at']);
            return DataTables::of($categories)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('Y-m-d') : '';
                })
                ->make(true);
        }
        return view('categories.index');
    }


    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Category::create([
            'name' => $request->name,
        ]);

        return response()->json(['success' => 'Category created successfully!']);
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Category $category, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $category->id . '|min:3',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $category->name = $request->name;
        $category->save();
        return response()->json(['success' => 'Category updated successfully!']);
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response()->json(['success' => 'Category Deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => 'Some problem occure'], 500);
        }
    }
}
