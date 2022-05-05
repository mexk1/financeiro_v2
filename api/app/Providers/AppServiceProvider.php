<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if( env( 'DB_DEBUG' ) ){
            DB::listen( function( $sql ) {
                Log::channel('database')->info( $sql->sql );
                Log::channel('database')->info( $sql->bindings );
            });
        }
    }
}
