<?php

namespace App\Http\Requests\Api\Authenticated\Account;

use App\Http\Requests\Api\Authenticated\AuthenticatedRequest;

class CreateAccountRequest extends AuthenticatedRequest{

    public function authorize( $ability = 'create_account' ){
        return parent::authorize( $ability );
    }

    public function rules(){
        return [
            "name" => [
                "required",
                "string",
                "max:255"
            ]
        ];
    }
}
