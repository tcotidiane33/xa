<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;
    protected $fillable = ['name', 'guard_name', 'description'];

    // La relation users est déjà définie dans SpatieRole, 
    // donc nous n'avons pas besoin de la redéfinir ici.

    // La relation permissions est également déjà définie dans SpatieRole.
    // Si vous voulez la personnaliser, vous pouvez la redéfinir comme ceci:
    /*
    public function permissions()
    {
        return $this->belongsToMany(
            config('permission.models.permission'),
            config('permission.table_names.role_has_permissions'),
            'role_id',
            'permission_id'
        );
    }
    */
    
}
