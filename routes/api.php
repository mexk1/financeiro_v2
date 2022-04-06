<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::name('api.')->group(function(){

    Route::name('open.')->group( __DIR__ . "/api/open/index.php" );
    Route::name('auth.')->prefix( "auth" )->group(  __DIR__ . "/api/auth/index.php" );

    Route::middleware( "auth:sanctum" )->group(  __DIR__ . "/api/authenticated/index.php" );

});
