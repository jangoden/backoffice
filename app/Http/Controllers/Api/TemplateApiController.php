<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;
use App\Http\Resources\TemplateApiResource; // <-- Import Resource Anda

class TemplateApiController extends Controller
{
    /**
     * Menampilkan daftar semua template.
     */
    public function index()
    {
        // Ambil semua data template
        $templates = Template::all();

        // Gunakan Resource untuk memformat collection data
        return TemplateApiResource::collection($templates);
    }

    // Anda bisa menambahkan method lain (store, show, update, destroy) di sini nanti
}