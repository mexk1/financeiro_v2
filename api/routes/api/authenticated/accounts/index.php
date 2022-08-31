<?php

use App\Http\Controllers\Api\Authenticated\AccountController;
use Illuminate\Support\Facades\Route;

Route::controller( AccountController::class )->group( function(){
    Route::get("/", "list" )->name('list');
    Route::post("/", "create" )->name('create');

    Route::prefix('{account}')->group( function(){

        Route::get("/", "read"  )->name('read');
        Route::patch("/", "update" )->name('update');
        Route::delete("/", "desactivate" )->name('desactivate');
        Route::get("/payment-methods", "paymentMethods" )->name('paymentMethods');

        Route::name('bank-accounts.')
            ->prefix('bank-accounts')
            ->group( __DIR__ . "/bank-accounts/index.php" );

        Route::name('spends.')
            ->prefix('spends')
            ->group( __DIR__ . "/spends/index.php" );

            
        Route::name('cards.')
          ->prefix('cards')
          ->group( __DIR__ . "/cards/index.php" );
    });
});
