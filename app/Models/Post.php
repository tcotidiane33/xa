<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'content', 'mentions', 'attachments'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mentions()
    {
        return $this->belongsToMany(User::class, 'post_user_mentions');
    }

    public function getMentionsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getAttachmentsAttribute($value)
    {
        return json_decode($value, true);
    }
}
