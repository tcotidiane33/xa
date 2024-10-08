<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionnaireClient extends Model
{
    use HasFactory;

    // protected $table = 'gestionnaire_client';
    protected $table = 'gestionnaire_client_pivot';


    // protected $fillable = [
    //     'client_id',
    //     'gestionnaire_id',
    //     'is_principal',
    //     'gestionnaires_secondaires',
    //     'user_id',
    //     'notes'
    // ];

    protected $fillable = [
        'client_id',
        'gestionnaire_id',
        'is_principal',
    ];

    protected $casts = [
        'is_principal' => 'boolean',
        // 'gestionnaires_secondaires' => 'array',
    ];
  

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function gestionnaire()
    {
        return $this->belongsTo(User::class, 'gestionnaire_id');
    }
 

//     public function responsablePaie()
//     {
//         return $this->belongsTo(User::class, 'user_id');
//     }
//     public function gestionnairesSecondaires()
//     {
//         return User::whereIn('id', $this->gestionnaires_secondaires ?: [])->get();
//     }

//     public function documents()
// {
//     return $this->hasMany(Document::class);
// }
}