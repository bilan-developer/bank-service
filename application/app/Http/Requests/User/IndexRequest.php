<?php

namespace App\Http\Requests\User;

use App\Models\User\User;

class IndexRequest extends \App\Http\Requests\Base\IndexRequest
{
    protected array $sortableFields = User::SORTABLE_FIELDS;
}
