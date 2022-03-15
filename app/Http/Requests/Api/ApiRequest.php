<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ApiRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    // protected function failedValidation( Validator $validator ){

    //     $data = $validator->getMessageBag();
    //     $response = response()->json( $data, 422 );
    //     throw new ValidationException( $validator, $response );
    // }
}
