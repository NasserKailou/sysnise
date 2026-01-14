<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(10);
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:permissions,name',
            'label' => 'nullable|string'
        ]);

        Permission::create($data);
        return redirect()->route('admin.permissions.index')->with('success', 'Permission créée.');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
            'label' => 'nullable|string'
        ]);

        $permission->update($data);
        return redirect()->route('admin.permissions.index')->with('success', 'Permission mise à jour.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return back()->with('success', 'Permission supprimée.');
    }
}
