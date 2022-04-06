<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

abstract class ApiRequest extends FormRequest
{
    /**
     * @return bool
     */
    abstract public function authorize();

    /**
     * @return array
     */
    abstract public function rules();

    final protected function failedValidation( Validator $validator ){
        $data = [
            "errors" => $validator->getMessageBag()
        ];
        $response = response()->json( $data, 422 );
        throw new ValidationException( $validator, $response );
    }
}
