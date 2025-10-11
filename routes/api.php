<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\TemplateApiController;
use App\Http\Controllers\Api\TemplateCategoryApiController;


Route::prefix('v1')->group(function () {
  Route::get('posts', [PostApiController::class, 'index']);
  Route::get('posts/{slug}', [PostApiController::class, 'show']);
  Route::get('templates', [TemplateApiController::class, 'index']);
  Route::get('templates/{template:slug}', [TemplateApiController::class, 'show']);
  Route::get('template-categories', [TemplateCategoryApiController::class, 'index']);
});

