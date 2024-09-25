<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleFontService
{
    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function getFonts()
    {
        $response = $this->client->request(
            'GET',
            'https://www.googleapis.com/webfonts/v1/webfonts',
            [
                'query' => [
                    'key' => $this->apiKey,
                ],
            ]
        );

        return $response->toArray();
    }
}
