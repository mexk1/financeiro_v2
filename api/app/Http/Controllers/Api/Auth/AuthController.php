<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function __construct(){
        $this->middleware('auth:sanctum')->except('login');
    }

    public function login( LoginRequest $request ){
        if( $request->user() ){
            return response( null, 406 );
        }
        /**
         * @var \App\Models\User $user
         */
        $user = User::where('email', $request->email )->first();

        if( !$user ){
            return response()->json( "the provided credential are incorrect" , 401 );
        }

        if( !$user->hasVerifiedEmail() ){
            return response()->json([ "errors" => [
              "email" => "You need to confirm your email first"
            ] ], 422 );
        }

        if( Hash::check(  $request->password, $user->password ) ){
            $token = $user->createToken( "auth" )->plainTextToken;
            return response( $token, 201 );
        }

        return response()->json([
            "email" => "the provided credential ara incorrect"
        ], 401 );
    }

    public function logout( Request $request ){

        if( !$user = $request->user() ) return response( null, 401 );
        if( !$token = $user->currentAccessToken() ) return response( null, 401 );

        try {
            $token->delete();
            return response( null, 200 );
        } catch (\Throwable $th) { report( $th ); }

        return response( null, 503 );
    }
}
