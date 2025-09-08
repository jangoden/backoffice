<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\TemplateApiController;


Route::prefix('v1')->group(function () {
  Route::get('posts', [PostApiController::class, 'index']);
  Route::get('posts/{slug}', [PostApiController::class, 'show']);
  Route::get('templates', [TemplateApiController::class, 'index']);
});

