<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TemplateCategoryResource;
use App\Models\TemplateCategory;
use Illuminate\Http\Request;

class TemplateCategoryApiController extends Controller
{
    /**
     * Menampilkan daftar semua kategori template.
     */
    public function index(Request $request)
    {
        $categories = TemplateCategory::query()
            ->withCount('templates') // Menghitung jumlah template per kategori
            ->orderBy('name')
            ->get();

        return TemplateCategoryResource::collection($categories);
    }
}
