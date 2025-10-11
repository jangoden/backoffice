<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplateApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'demo_url' => $this->demo_url,
            // PERUBAHAN PENTING: Menggunakan nama kolom yang benar & helper asset()
            'image_url' => $this->image_preview ? asset('files/' . $this->image_preview) : null, 
            'description' => $this->description,
            'tags' => $this->tags,
            // PERUBAHAN PENTING: Menyertakan data kategori dari relasi
            'category' => $this->whenLoaded('templateCategory', function () {
                return [
                    'id' => $this->templateCategory->id,
                    'name' => $this->templateCategory->name,
                    'slug' => $this->templateCategory->slug,
                ];
            }),
        ];
    }
}
