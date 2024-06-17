<?php

use App\Http\Controllers\GetArticleDetailController;
use App\Http\Controllers\GetIndexController;
use App\Http\Controllers\PostArticlesController;
use Illuminate\Support\Facades\Route;

Route::get('/', GetIndexController::class);
Route::post('/articles', PostArticlesController::class);
Route::get('/articles/{article_id}', GetArticleDetailController::class);
