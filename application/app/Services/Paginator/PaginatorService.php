<?php

declare(strict_types=1);

namespace App\Services\Paginator;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Pagination\Paginator;

class PaginatorService
{
    /**
     * @param $query
     * @param array $data
     *
     * @return Paginator
     */
    public function paginate($query, array $data): Paginator
    {
        $limit = Arr::get($data, Config::get("pagination.limit_key")) ?: Config::get('pagination.limit_per_page');
        return $query->paginate($limit);
    }

    /**
     * @param $query
     * @param array $data
     *
     * @return self
     */
    public function sort($query, array $data): self
    {
        $sort = $this->getSortColumn($data);
        $order = $this->getDirectionColumn($data);
        $query->when($sort, function ($query) use ($sort, $order) {
            return $query->orderBy($sort, $order);
        });

        return $this;
    }

    /**
     * @param array $data
     *
     * @return string
     */
    public function getSortColumn(array $data): string
    {
        return Arr::get($data, Config::get("pagination.sort_key"), Config::get("pagination.default_field"));
    }

    /**
     * @param array $data
     *
     * @return string
     */
    public function getDirectionColumn(array $data): string
    {
        return Arr::get($data, Config::get("pagination.order_key"), Config::get("pagination.order_direction"));
    }
}
