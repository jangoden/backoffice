<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage; // <-- Import Storage facade

class TemplateApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $this->category,
            // Mengubah path gambar menjadi URL lengkap
            'imageUrl' => Storage::url($this->imageUrl),
            'description' => $this->description,
            'demoUrl' => $this->demoUrl,
            // 'tags' akan otomatis di-handle oleh Model
            'tags' => $this->tags,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}