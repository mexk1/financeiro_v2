<?php

use App\Http\Controllers\Api\Authenticated\BankAccountController;
use Illuminate\Support\Facades\Route;

Route::get("/", [ BankAccountController::class, 'listCards'])->name('list');
Route::post("/", [ BankAccountController::class, 'createCard'])->name('create');
