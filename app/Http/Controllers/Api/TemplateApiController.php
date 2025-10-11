<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TemplateApiResource;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateApiController extends Controller
{
    /**
     * Menampilkan daftar semua template.
     */
    public function index(Request $request)
    {
        $templates = Template::query()
            // PERUBAHAN PENTING: Memuat relasi 'templateCategory' secara efisien
            ->with('templateCategory')
            
            // Filter berdasarkan slug kategori jika ada di request
            ->when($request->category, function ($query, $categorySlug) {
                $query->whereHas('templateCategory', function ($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            })
            ->latest() // Urutkan dari yang terbaru
            ->paginate(12); // Paginasi data

        return TemplateApiResource::collection($templates);
    }
    
    /**
     * Menampilkan satu template spesifik.
     */
    public function show(Template $template)
    {
        // Memuat relasi agar data kategori juga muncul di halaman detail
        $template->load('templateCategory');
        return new TemplateApiResource($template);
    }
}