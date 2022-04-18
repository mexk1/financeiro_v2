<?php

use App\Http\Controllers\Api\Authenticated\BankAccountController;
use Illuminate\Support\Facades\Route;

Route::post("/", [ BankAccountController::class, 'createCard'])->name('create');
