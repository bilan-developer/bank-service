<?php

namespace App\Http\Requests\MoneyTransfer;

use App\Rules\NegativeBalanceRule;
use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'from_wallet_id' => [
                'required',
                'exists:wallets,id',
                new NegativeBalanceRule($this->currency_code, $this->amount)
            ],
            'to_wallet_id' => [
                'required',
                'exists:wallets,id'
            ],
            'amount' => [
                'required',
                'numeric'
            ],
            'currency_code' => [
                'required',
                'exists:currencies,code'
            ],
        ];
    }
}
