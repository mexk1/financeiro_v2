<?php

use Illuminate\Support\Facades\Route;

Route::name('accounts.')
    ->prefix('accounts')
    ->group( __DIR__ . "/accounts/index.php" );


Route::name('bank-accounts.')
    ->prefix('bank-accounts')
    ->group( __DIR__ . "/bank-accounts/index.php" );


Route::name('cards.')
    ->prefix('cards')
    ->group( __DIR__ . "/cards/index.php" );


Route::name('me.')
    ->prefix('me')
    ->group( __DIR__ . "/me/index.php" );
