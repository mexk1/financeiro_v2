<?php

namespace App\Http\Requests\Api\Authenticated\Account;

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
              'required',
              Rule::in([ "credit", "debit", "both" ])
            ],
            'bank_account' => [
              'required',
              'exists:bank_accounts,id'
            ],
            'limit' => [
                'nullable',
                'integer'
            ],
            'bill_close_day' => [
              'required',
              'min:1',
              'max:31',
              'numeric',
              'integer'
            ],
        ];
    }
}
