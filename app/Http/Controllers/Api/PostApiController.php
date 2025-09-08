<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;

class PostApiController extends Controller
{
    public function index()
    {
        $q = Post::with(['user','category'])
            ->where('status','published')
            ->where('published_at','<=', now())
            ->orderByDesc('published_at')
            ->paginate(10);

        return PostResource::collection($q);
    }

    public function show(string $slug)
    {
        $post = Post::with(['user','category'])
            ->where('status','published')
            ->where('published_at','<=', now())
            ->where('slug', $slug)
            ->firstOrFail();

        return new PostResource($post);
    }
}
