<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    // Allow mass assignment
    protected $fillable = [
        'file_name',
        'file_path',
        'mime_type',
        'size',
    ];

    /**
     * Optional: get the post associated with this media
     */
    public function post()
    {
        return $this->hasOne(Post::class);
    }

    /**
     * Accessor to get full URL for the media
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}
