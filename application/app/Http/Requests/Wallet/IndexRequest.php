<?php

namespace App\Http\Requests\Wallet;

class IndexRequest extends \App\Http\Requests\Base\IndexRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'currency_id' => ['sometimes', 'exists:currencies,id'],
           ...parent::rules()
        ];
    }
}
