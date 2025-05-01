<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware():array
    {
        return[
            new Middleware('permission:view permissions', only: ['index']),
            new Middleware('permission:edit permissions', only: ['edit']),
            new Middleware('permission:create permissions', only: ['create']),
            new Middleware('permission:delete permissions', only: ['destroy']),
        ];
    }


    // This method will show permission page
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Permission::latest()->select(['id', 'name', 'created_at']);
    
            return FacadesDataTables::of($query)
                // 1. Add a serial number column
                ->addIndexColumn()
                
                // 2. Format the created_at value
                ->editColumn('created_at', function (Permission $permission) {
                    return $permission->created_at->format('d, M, Y');
                })
                
                ->make(true);
        }
    
        return view('permissions.list');
    }

    // This method will create permission page
    public function create()
    {
        return view('permissions.create');
    }

    // This method will store permission in DB
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Permission::create([
            'name' => $request->name,
        ]);

        return response()->json(['success' => 'Permission submitted successfully!']);
    }



    // This method will edit permission page
    public function edit($permission) {
        $permission = Permission::findOrFail($permission);
        return view('permissions.edit', [
            'permission' => $permission
        ]);
    }

    // This method will update permission in DB
    public function update(Permission $permission, Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name,' . $permission->id . '|min:3',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $permission->name = $request->name;
        $permission->save();  // or ->update();
        return response()->json(['success' => 'Permission updated successfully!']);
    }

    // This method will delete a permission from DB
    public function destroy(Permission $permission) {
        try {
            $permission->delete();
            return response()->json(['success' => 'Permission Deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => 'Some problem occure'], 500);
        }
    }
}
