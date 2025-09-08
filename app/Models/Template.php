<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'imageUrl',
        'description',
        'demoUrl',
        'tags'
    ];

    /**
     * Casting atribut ke tipe data tertentu.
     */
    protected $casts = [
        'tags' => 'array', // <-- Tambahkan ini
    ];
}