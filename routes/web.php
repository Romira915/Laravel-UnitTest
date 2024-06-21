<?php

use App\Http\Controllers\Articles\GetArticleEditController;
use App\Http\Controllers\Articles\PostArticles\PostArticleIdDeleteController;
use App\Http\Controllers\Auth\GetAuthLoginController;
use App\Http\Controllers\Auth\GetAuthRegisterController;
use App\Http\Controllers\Auth\PostAuthLoginController;
use App\Http\Controllers\Auth\PostAuthLogoutController;
use App\Http\Controllers\Auth\PostAuthRegisterController;
use App\Http\Controllers\GetArticlesArticleIdController;
use App\Http\Controllers\GetIndexController;
use App\Http\Controllers\PostArticlesController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::middleware('current_user')->group(function () {
    Route::get('/', GetIndexController::class);
    Route::get('/articles/{article_id}', GetArticlesArticleIdController::class);
    Route::get('/articles/{article_id}/edit', GetArticleEditController::class);
});

Route::middleware(['auth', 'current_user'])->group(function () {
    Route::post('/articles', PostArticlesController::class);
    Route::post('/articles/{article_id}/delete', PostArticleIdDeleteController::class);
});

Route::prefix('auth')->group(function () {
    Route::get('/login', GetAuthLoginController::class)->name('show_login_page');
    Route::post('/login', PostAuthLoginController::class)->name('login');
    Route::post('/logout', PostAuthLogoutController::class)->withoutMiddleware(VerifyCsrfToken::class)->name('logout');
    Route::get('/register', GetAuthRegisterController::class)->name('show_register_page');
    Route::post('/register', PostAuthRegisterController::class)->name('register');
});
