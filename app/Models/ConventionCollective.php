<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConventionCollective extends Model
{
    protected $table = 'convention_collectives';
     // Define the fillable fields
     protected $fillable = [
        'name',
        'description',
        // ...
    ];


    public function clients()
{
    return $this->hasMany(Client::class);
}
}
