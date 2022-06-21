<?php

namespace App\Consumer;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OMDbApiConsumer
{
    public function __construct(
        private HttpClientInterface $omdbClient
    ) {}

    public function fetch(string $title)
    {
        return $this->omdbClient->request(
            Request::METHOD_GET,
            '',
            [
                'query' => [
                    't' => $title,
                ]
            ]
        );
    }
}