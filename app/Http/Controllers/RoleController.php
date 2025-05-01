<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware():array
    {
        return[
            new Middleware('permission:view roles', only: ['index']),
            new Middleware('permission:edit roles', only: ['edit']),
            new Middleware('permission:create roles', only: ['create']),
            new Middleware('permission:delete roles', only: ['destroy']),
        ];
    }


    // This method will show roles page
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Role::with('permissions')->latest()->select(['id', 'name', 'created_at']);

            return FacadesDataTables::of($query)
                ->addIndexColumn()
                // format created_at:
                ->editColumn('created_at', function (Role $role) {
                    return $role->created_at->format('d, M, Y');
                })
                ->editColumn('permissions', fn(Role $r) => $r->permissions->pluck('name')->join(', '))
                ->make(true);
        }

        return view('roles.list');
    }


    // This method will create roles page
    public function create()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();

        return view('roles.create', [
            'permissions' => $permissions
        ]);
    }


    // This method will store roles in DB
    public function store(Request $request)
    {
        // 1. Validate input
        $validated = $request->validate([
            'name'        => 'required|unique:roles|min:3',
            'permission'  => 'sometimes|array',
            'permission.*' => 'string|exists:permissions,name',
        ]);

        // 2. Create the new role
        $role = Role::create([
            'name' => $validated['name'],
        ]);

        // 3. Assign any selected permissions
        if (!empty($validated['permission'])) {
            foreach ($validated['permission'] as $permName) {
                $role->givePermissionTo($permName);
            }
        }

        // 4. Return a JSON success response
        return response()->json(['success' => "Role Added Successfully"]);
    }


    // This method will edit role page
    public function edit($role)
    {
        $role = Role::findOrFail($role);
        $hasPermissions = $role->permissions->pluck('name');
        // dd($hasPermissions);
        $permissions = Permission::orderBy('name', 'ASC')->get();

        return view('roles.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'hasPermissions' => $hasPermissions,
        ]);
    }

    // This method will update role in DB
    public function update(Role $role, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $role->id . '|min:3',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $role->name = $request->name;
        $role->save();

        if (!empty($request->permission)) {
            $role->syncPermissions($request->permission);
        }else{
            $role->syncPermissions([]);
        }

        return response()->json(['success' => 'Roles updated successfully!']);
    }

    // This method will delete a role from DB
    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return response()->json(['success' => 'Role Deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => 'Some Problem Occured'], 500);
        }
    }
}
