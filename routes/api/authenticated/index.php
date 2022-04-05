<?php

use Illuminate\Support\Facades\Route;

Route::name('accounts.')->prefix('accounts')->group( __DIR__ . "/accounts/index.php" );
