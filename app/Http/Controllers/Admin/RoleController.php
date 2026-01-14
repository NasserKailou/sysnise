<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name',
            'label' => 'nullable|string',
            'permissions' => 'array'
        ]);

        $role = Role::create($data);
        $role->permissions()->sync($data['permissions'] ?? []);

        return redirect()->route('admin.roles.index')->with('success', 'Rôle créé avec succès.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'label' => 'nullable|string',
            'permissions' => 'array'
        ]);

        $role->update($data);
        $role->permissions()->sync($data['permissions'] ?? []);

        return redirect()->route('admin.roles.index')->with('success', 'Rôle mis à jour avec succès.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return back()->with('success', 'Rôle supprimé.');
    }
}
