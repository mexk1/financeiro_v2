<?php

use App\Http\Controllers\Api\Authenticated\BankAccountController;
use Illuminate\Support\Facades\Route;

Route::prefix('{bank_account}')->group(function(){
    Route::patch('/',   [ BankAccountController::class, 'update'        ])->name('update');
    Route::delete('/',  [ BankAccountController::class, 'desactivate'   ])->name('desactivate');
});
