<?php

use App\Http\Controllers\Api\Authenticated\BankAccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ BankAccountController::class, 'list'])->name('list');
Route::post('/', [ BankAccountController::class, 'create'])->name('create');
