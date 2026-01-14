<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
	{
		$roles = Role::all();
		return view('admin.users.create', compact('roles'));
	}

	public function edit($id)
	{
		$user = User::findOrFail($id);
		$roles = Role::all();
		$userRoleIds = $user->roles->pluck('id')->toArray();

		return view('admin.users.edit', compact('user', 'roles', 'userRoleIds'));
	}

}
