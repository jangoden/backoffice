<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class PostResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'slug'           => $this->slug,
            'content'        => $this->content,
            'author'         => $this->user->name ?? null,
            'category'       => $this->category->name ?? null,

            // URL absolut → contoh: http://127.0.0.1:8000/storage/post-images/xxx.jpg
            'image_url'      => $this->featured_image
                ? URL::to(Storage::url($this->featured_image))
                : null,

            'published_at'   => $this->published_at?->toIso8601String(),
            'published_date' => $this->published_at?->format('d F Y'),
        ];
    }
}
