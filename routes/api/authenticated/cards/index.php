<?php

use App\Http\Controllers\Api\Authenticated\CardsController;
use Illuminate\Support\Facades\Route;


Route::controller( CardsController::class )->group( function(){
    Route::prefix('{card}')->group( function(){
        Route::patch( '/', 'update')->name('update');
        Route::delete( '/', 'desactivate')->name('desactivate');
    });
});
