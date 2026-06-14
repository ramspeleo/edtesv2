<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        return view('roles.index');
    }

    public function ajaxData()
    {
        $roles = Role::with('permissions')->select('roles.*');

        return DataTables::of($roles)
            ->addColumn('description', function ($role) {
                return $role->description ?? '<span class="text-muted">No description</span>';
            })
            ->addColumn('permissions', function ($role) {
                if ($role->permissions->isEmpty()) {
                    return '<span class="text-muted">No permissions</span>';
                }

                return $role->permissions
                    ->pluck('name')
                    ->map(fn ($permission) => '<span class="badge bg-primary me-1 mb-1">' . e($permission) . '</span>')
                    ->implode(' ');
            })
            ->addColumn('action', function ($role) {
                return '
                    <a href="' . route('roles.edit', $role->id) . '" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                ';
            })
            ->rawColumns(['description', 'permissions', 'action'])
            ->make(true);
    }

    public function edit(Role $role)
    {
        $role->load('permissions');

        $permissions = Permission::orderBy('name')->get();

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        if ($request->save_type === 'add_permission') {
            $request->validate([
                'new_permission' => 'required|string|max:255|unique:permissions,name',
            ]);

            Permission::create([
                'name' => $request->new_permission,
                'guard_name' => $role->guard_name ?? 'web',
            ]);

            return back()->with('success', 'New permission added. You may now assign it to the role.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'guard_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->update([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'],
            'description' => $validated['description'] ?? null,
        ]);

        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }
}