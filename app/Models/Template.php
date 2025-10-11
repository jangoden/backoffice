<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Template extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'category', // Kolom lama
        'demo_url',
        'image_preview',
        'description',
        'tags',
        'template_category_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tags' => 'array', // <-- INI SOLUSINYA! Mengajari Laravel untuk menangani 'tags' sebagai array.
    ];

    /**
     * Get the template category that owns the Template.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function templateCategory(): BelongsTo
    {
        return $this->belongsTo(TemplateCategory::class);
    }
}
