<?php

namespace App\Http\Requests\TransferHistory;

use App\Models\TransferHistory\TransferHistory;

class IndexRequest extends \App\Http\Requests\Base\IndexRequest
{
    /**
     * @var array
     */
    protected array $sortableFields = TransferHistory::SORTABLE_FIELDS;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'wallet_id' => ['required', 'exists:wallets,id'],
            ...parent::rules()
        ];
    }
}
