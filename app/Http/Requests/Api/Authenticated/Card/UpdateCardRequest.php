<?php

namespace App\Http\Requests\Api\Authenticated\Card;

use App\Http\Requests\Api\Authenticated\AuthenticatedRequest;
use Illuminate\Validation\Rule;

class UpdateCardRequest extends AuthenticatedRequest
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
                'nullable',
                'max:255'
            ],
            'last_digits' => [
                'nullable',
                'max:4',
            ],
            'bill_close_day' => [
                'date_format:d'
            ],
            'mode' => [
                'nullable',
                Rule::in([ "credit", "debit", "both" ])
            ],
            'limit' => [
                'nullable',
                'integer'
            ]
        ];
    }
}
