<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'path', 'client_id', 'gestionnaire_client_id', 'file_path'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function gestionnaireClient()
    {
        return $this->belongsTo(GestionnaireClient::class);
    }
    
}
