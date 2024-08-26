<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'client_id',
        'user_id',
        'title',
        'type',
        'content',
        'content_url',
        'field_name'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function history()
    {
        return $this->hasMany(MaterialHistory::class);
    }
}
