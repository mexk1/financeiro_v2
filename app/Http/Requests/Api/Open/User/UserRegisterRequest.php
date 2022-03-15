<?php

namespace App\Http\Requests\Api\Open\User;

use App\Http\Requests\Api\ApiRequest;
use Illuminate\Validation\Rules\Password;

class UserRegisterRequest extends ApiRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => [
                "required",
                "string",
                "max:255"
            ],
            "email" => [
                "email",
                "required",
                "unique:users,id"
            ],
            "password" => [
                Password::min(6),
                "required",
                "confirmed"
            ]
        ];
    }
}
