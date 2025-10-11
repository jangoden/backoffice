<?php

use Illuminate\Support\Facades\Route;

// Arahkan root ke Filament panel (auto login page jika belum login)
Route::redirect('/', '/admin');

// Route untuk serve file storage (mengatasi masalah symlink)
Route::get('/storage-test', function () {
    return response('Storage test working');
});

Route::get('/files/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    
    if (!file_exists($filePath)) {
        return response('File not found: ' . $filePath, 404);
    }
    
    return response()->file($filePath);
})->where('path', '.*');

// (opsional) semua URL tak dikenal → ke /admin
Route::fallback(fn () => redirect('/admin'));
