<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function providePublicUrls()
    {
        yield 'index' => ['/', 200];
        yield 'contact' => ['/contact', 200];
        yield 'book' => ['/book', 200];
        yield 'toto' => ['/toto', 404];
    }

    /**
     * @dataProvider providePublicUrls
     */
    public function testPublicUrlIsSuccessful(string $url, int $statusCode): void
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertResponseStatusCodeSame($statusCode);
    }
}
