<?php

declare(strict_types=1);

namespace App\Interfaces;

interface HttpClientInterface
{
    public function request(string $url, mixed $options = null): mixed;
}
