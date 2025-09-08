<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi mass assignment
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'status',
        'published_at',
        'cover_url',
        'category_id',
        'user_id',
        'featured_image',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Relasi ke Category (satu post punya satu kategori).
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke User (penulis post).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
