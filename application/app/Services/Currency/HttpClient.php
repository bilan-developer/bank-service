<?php

declare(strict_types=1);

namespace App\Services\Currency;

use App\Interfaces\HttpClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Config;

class HttpClient implements HttpClientInterface
{
    /**
     * @param string $url
     * @param string $options
     *
     * @return mixed
     * @throws GuzzleException
     */
    public function request(string $url, mixed $options = null): mixed
    {
        $client = $this->getClient();
        $response = $client->get($url, []);
        return $response->getBody()->getContents();
    }

    /**
     * @return Client
     */
    private function getClient(): Client
    {
        return new Client(['base_uri' => Config::get('currency.url')]);
    }
}
