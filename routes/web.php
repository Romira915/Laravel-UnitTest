<?php

use App\Http\Controllers\GetIndexController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GetIndexController::class, 'index']);
