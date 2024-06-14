<?php

use App\Http\Controllers\GetIndexController;
use App\Http\Controllers\PostArticlesController;
use Illuminate\Support\Facades\Route;

Route::get('/', GetIndexController::class);
Route::post('/articles', PostArticlesController::class);
