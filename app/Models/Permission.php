<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatiePermission;


class Permission extends SpatiePermission
{
    use HasFactory;

    protected $fillable = ['name', 'guard_name', 'description'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

}
