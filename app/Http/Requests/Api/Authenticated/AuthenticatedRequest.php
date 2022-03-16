<?php

namespace App\Http\Requests\Api\Authenticated;

use App\Http\Requests\Api\ApiRequest;

class AuthenticatedRequest extends ApiRequest{

    public function authorize( $ability = '*' )
    {
        /**
         * @var \App\Models\User $user
         */
        $user = request()->user("sanctum");

        // file_put_contents( __DIR__. "/log.json", $user->currentAccessToken()->can('*') );
        return $user && $user->currentAccessToken()->can( $ability );
    }
}
