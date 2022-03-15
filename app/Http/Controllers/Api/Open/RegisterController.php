<?php


namespace App\Http\Controllers\Api\Open;

use App\Events\User\UserCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Open\User\UserRegisterRequest;
use App\Services\CRUD\User\CreateUserService;

class RegisterController extends Controller{

    public function register( UserRegisterRequest $request ){

        $service = new CreateUserService( $request->validated() );

        try {
            $user = $service->run();
            if( $user ){
                UserCreatedEvent::dispatch( $user );
                return response()->json( $user, 201 );
            }
        } catch (\Throwable $th) { report( $th ); }

        return response( null, 503 );
    }

}
