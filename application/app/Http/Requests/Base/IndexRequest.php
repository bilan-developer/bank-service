<?php

declare(strict_types=1);

namespace App\Http\Requests\Base;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
{
    /**
     * @var array
     */
    protected array $sortableFields = [];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Config::get('pagination.limit_key') => ['sometimes', 'numeric'],
            Config::get('pagination.page_key') => ['sometimes', 'numeric'],
            Config::get('pagination.search_key') => ['nullable', 'string', 'min:2', 'max:255'],
            Config::get('pagination.sort_key') => ['nullable', Rule::in($this->sortableFields)],
            Config::get('pagination.order_key') => ['nullable', Rule::in(Config::get('pagination.order_directions'))],
        ];
    }
}
