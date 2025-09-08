<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    // IZINKAN kolom yang diisi dari form
    protected $fillable = [
        'title',
        'github_link',
    ];

}
