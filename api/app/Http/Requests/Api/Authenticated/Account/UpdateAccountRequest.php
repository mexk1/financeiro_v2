<?php

namespace App\Http\Requests\Api\Authenticated\Account;

use App\Http\Requests\Api\Authenticated\AuthenticatedRequest;

class UpdateAccountRequest extends AuthenticatedRequest{

    public function authorize( $ability = 'update_account' ){
        $account = request()->route()->parameter('account', false );
        return parent::authorize( $ability )
            && $account
            && request()->user('sanctum')->id === $account->owner->id ;
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
