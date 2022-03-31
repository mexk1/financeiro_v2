<?php

use App\Http\Controllers\Api\Authenticated\AccountController;
use Illuminate\Support\Facades\Route;

Route::controller( AccountController::class )->group( function(){
    Route::get("/", "list" );
    Route::post("/", "create" );

    Route::prefix('{account}')->group( function(){
        Route::get("/", "read" );
        Route::patch("/", "update" );
        Route::delete("/", "desactivate" );

        Route::get("/payment-methods", "paymentMethods" );
    });
});
