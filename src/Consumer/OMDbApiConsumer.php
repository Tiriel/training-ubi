<?php

namespace App\Consumer;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OMDbApiConsumer
{
    public const MODE_TITLE = 't';
    public const MODE_ID = 'i';

    public function __construct(
        private HttpClientInterface $omdbClient
    ) {}

    public function getMovieByTitle(string $title): array
    {
        return $this->getOneMovie(self::MODE_TITLE, $title);
    }

    public function getMovieById(string $id): array
    {
        return $this->getOneMovie(self::MODE_ID, $id);
    }

    private function getOneMovie(string $mode, string $value): array
    {
        if (!in_array($mode, [self::MODE_ID, self::MODE_TITLE])) {
            throw new \RuntimeException(sprintf("Unsupported mode, must be one of %s or %s, %s given",
                self::MODE_ID, self::MODE_TITLE, $mode));
        }

        $response = $this->omdbClient->request(
            Request::METHOD_GET,
            '',
            [
                'query' => [
                    $mode => $value,
                ]
            ]
        )->toArray();

        if (array_key_exists('Response', $response) && $response['Response'] === 'False') {
            throw new NotFoundHttpException('Movie not found.');
        }

        return $response;
    }
}