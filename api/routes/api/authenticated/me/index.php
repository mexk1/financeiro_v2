<?php

use App\Http\Controllers\Api\Authenticated\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ UserController::class, 'me' ])->name('show');
