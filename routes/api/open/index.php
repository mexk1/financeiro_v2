<?php

use App\Http\Controllers\Api\Open\RegisterController;
use Illuminate\Support\Facades\Route;

Route::name("register")->post("/register", [ RegisterController::class, 'register' ] );
