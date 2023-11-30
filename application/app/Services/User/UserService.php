<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Models\User\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class UserService
{
    /**
     * @param array $data
     *
     * @return Paginator
     */
    public function list(array $data): Paginator
    {
        $query = User::query();

        if (Arr::has($data, Config::get('pagination.search_key'))) {
            $search = Arr::get($data, Config::get('pagination.search_key'));
            $pattern = "%${$search}%";
            $query->where(
                fn(Builder $q) => $q->where('name', 'like', $pattern)
                    ->orWhere('email', 'like', $pattern)
            );
        }

        $limit = Arr::get($data, Config::get('pagination.limit_key'), Config::get('pagination.limit_per_page'));
        return $query->paginate($limit);
    }

    /**
     * @param $data
     * @param User $user
     *
     * @return User
     */
    public function update($data, User $user): User
    {
        $user->fill($data)->save();

        return $user;
    }
}
