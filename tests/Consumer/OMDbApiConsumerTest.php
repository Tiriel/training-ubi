<?php

namespace App\Tests\Consumer;

use App\Consumer\OMDbApiConsumer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OMDbApiConsumerTest extends TestCase
{
    private static MockHttpClient $client;
    private static OMDbApiConsumer $consumer;

    public static function setUpBeforeClass(): void
    {
        static::$client = new MockHttpClient();
        static::$consumer = new OMDbApiConsumer(static::$client);
    }

    public function testGetMovieByTitle(): void
    {
        $infos= [
            'http_code' => 200,
        ];
        $response = new MockResponse('{"Title":"Star Wars"}', $infos);
        static::$client->setResponseFactory($response);

        $data = static::$consumer->getMovieByTitle('Star Wars');

        $decoded = parse_url($response->getRequestUrl());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('query', $decoded);
        $this->assertEquals('t=Star%20Wars', $decoded['query']);
        $this->assertArrayHasKey('Title', $data);
    }

    public function testGetMovieByTitleThrowsWith404(): void
    {
        $this->expectException(NotFoundHttpException::class);
        $infos= [
            'http_code' => 200,
        ];
        $response = new MockResponse('{"Response": "False"}', $infos);
        static::$client->setResponseFactory($response);

        static::$consumer->getMovieByTitle('Star Wors');
    }
}
