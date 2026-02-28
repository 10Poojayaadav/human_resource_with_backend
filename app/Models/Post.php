<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Allow mass assignment
    protected $fillable = [
        'user_id',
        'media_id',
        'title',
        'slug',
        'content',
        'published',
        'published_at',
    ];

    /**
     * User who created the post
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Media attached to the post
     */
    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
}
