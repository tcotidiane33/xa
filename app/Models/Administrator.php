<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use OpenAdmin\Admin\Auth\Database\Administrator as BaseAdministrator;

class Administrator extends BaseAdministrator
{
    // use HasRoles;
    public function hasRole($role)
    {
        return $this->roles()->where('slug', $role)->exists();
    }

    public function roles()
    {
        return $this->belongsToMany(
            config('admin.database.roles_model'),
            config('admin.database.role_users_table'),
            'user_id',
            'role_id'
        );
    }
}