<?php

namespace App\Http\Requests\Api\Authenticated\BankAccount;

use App\Http\Requests\Api\Authenticated\AuthenticatedRequest;
use Illuminate\Validation\Rule;

class CreateCardRequest extends AuthenticatedRequest
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
                'max:255'
            ],
            'last_digits' => [
                'required',
                'max:4',
            ],
            'bill_close_day' => [
                'date_format:d'
            ],
            'mode' => [
                Rule::in([ "credit", "debit", "both" ])
            ],
            'limit' => [
                'nullable',
                'integer'
            ]
        ];
    }
}
