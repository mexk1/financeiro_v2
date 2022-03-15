<?php

use App\Http\Controllers\Api\Open\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post("/", [ RegisterController::class, 'register' ] );
