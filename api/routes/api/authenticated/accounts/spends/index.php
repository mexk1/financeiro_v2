<?php

use App\Http\Controllers\Api\Authenticated\AccountController;
use Illuminate\Support\Facades\Route;

Route::get("/", [ AccountController::class, 'listSpends' ])->name('list');
Route::post("/", [ AccountController::class, 'createSpend' ])->name('create');
