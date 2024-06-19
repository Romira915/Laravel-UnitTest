<?php

use App\Http\Controllers\Auth\GetAuthLoginController;
use App\Http\Controllers\Auth\PostAuthLoginController;
use App\Http\Controllers\GetArticlesArticleIdController;
use App\Http\Controllers\GetIndexController;
use App\Http\Controllers\PostArticlesController;
use Illuminate\Support\Facades\Route;

Route::get('/', GetIndexController::class);
Route::post('/articles', PostArticlesController::class);
Route::get('/articles/{article_id}', GetArticlesArticleIdController::class);

Route::prefix('auth')->group(function () {
    Route::get('/login', GetAuthLoginController::class)->name('show_login_page');
    Route::post('/login', PostAuthLoginController::class)->name('login');
});
