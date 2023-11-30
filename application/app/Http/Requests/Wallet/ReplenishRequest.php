<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Foundation\Http\FormRequest;

class ReplenishRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'currency_code' => ['required', 'exists:currencies,code'],
            'amount' => ['required', 'numeric'],
        ];
    }
}
