<?php

namespace App\Http\Requests\Api\Authenticated\BankAccount;

use App\Http\Requests\Api\Authenticated\AuthenticatedRequest;

class UpdateBankAccountRequest extends AuthenticatedRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ]
        ];
    }
}
