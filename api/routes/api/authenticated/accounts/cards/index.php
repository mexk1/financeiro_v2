<?php

use App\Http\Controllers\Api\Authenticated\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ AccountController::class, 'listCards' ])->name('list');
Route::post('/', [ AccountController::class, 'createCard' ])->name('create');