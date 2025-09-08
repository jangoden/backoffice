<?php

use Illuminate\Support\Facades\Route;

// Arahkan root ke Filament panel (auto login page jika belum login)
Route::redirect('/', '/admin');

// (opsional) semua URL tak dikenal → ke /admin
Route::fallback(fn () => redirect('/admin'));
