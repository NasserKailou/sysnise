<?php

namespace App\Models;

// ... autres uses
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // existing code...

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    // Attribuer un role
    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::firstOrCreate(['name' => $role]);
        }
        $this->roles()->syncWithoutDetaching($role);
        return $this;
    }

    // Retirer un role
    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        if ($role) {
            $this->roles()->detach($role);
        }
        return $this;
    }

    // Vérifier un rôle
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles()->where('name', $role)->exists();
        }
        return $this->roles()->where('id', $role->id)->exists();
    }

    // Vérifier permission via roles
    public function hasPermission($permission)
    {
        // $permission peut être string (nom) ou Permission model
        $permissionName = $permission instanceof \App\Models\Permission ? $permission->name : $permission;

        return $this->roles()
            ->whereHas('permissions', function ($q) use ($permissionName) {
                $q->where('name', $permissionName);
            })
            ->exists();
    }

    // Récupère les permissions du user (collection)
    public function permissions()
    {
        return \App\Models\Permission::whereHas('roles', function($q){
            $q->whereIn('roles.id', $this->roles->pluck('id'));
        })->get();
    }
}
