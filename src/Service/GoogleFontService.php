<?php

namespace App\Service;

use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleFontService
{
    private $client;
    private $apiKey;
    private $cache;

    public function __construct(HttpClientInterface $client, string $apiKey, CacheInterface $cache)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
        $this->cache = $cache;
    }

    public function getFonts()
    {

        return $this->cache->get('google_fonts', function (ItemInterface $item) {
            $item->expiresAfter(36000);

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
        });
    }
}
