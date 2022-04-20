<?php

namespace App\Http\Requests\Api\Authenticated\Account;

use App\Http\Requests\Api\Authenticated\AuthenticatedRequest;

class CreateSpendRequest extends AuthenticatedRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'value' => [
                'required',
                'min:0.01',
                'numeric'
            ]
        ];
    }
}
