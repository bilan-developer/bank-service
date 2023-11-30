<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => ['sometimes', 'string'],
            "age" => ['sometimes', 'integer', "min:0", "max:255"],
            "email" => ['sometimes', 'email', 'unique:users,email,' . $this->user->id],
        ];
    }
}
