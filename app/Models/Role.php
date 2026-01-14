<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //protected $table = 'role';
	protected $fillable = ['name','label'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    // helper
    public function givePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::firstOrCreate(['name' => $permission]);
        }
        $this->permissions()->syncWithoutDetaching($permission);
        return $this;
    }
}
