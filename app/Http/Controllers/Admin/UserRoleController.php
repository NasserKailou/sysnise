<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function updateRoles(Request $request, User $user)
    {
        $user->roles()->sync($request->roles ?? []);
        return back()->with('success', "Rôles mis à jour pour {$user->name}.");
    }
}
