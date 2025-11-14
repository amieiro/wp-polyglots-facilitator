<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TranslationController;
use Illuminate\Support\Facades\Route;

Route::get('/locale/change', [HomeController::class, 'localeChange']);
Route::get('/locale/{id}', [HomeController::class, 'language']);
Route::get('/', [HomeController::class, 'index']);
Route::post('/', [TranslationController::class, 'downloadAndReplace']);
