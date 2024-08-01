<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'status', 'user_id', 'screenshot'
    ];

     /**
     * Relation : Un ticket appartient à un utilisateur (créateur).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : Un ticket peut être assigné à plusieurs utilisateurs (si nécessaire).
     */
    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'ticket_user');
    }
}
