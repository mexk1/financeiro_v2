<?php

namespace App\Http\Controllers\Api\Authenticated;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function me( ){

        $user = auth('sanctum')->user();

        // if( !$user ) return response( null, 401 );
        // Authorization

        return response()->json( $user );
    }
}
