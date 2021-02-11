<?php
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\ServerRequestFactory;

class QuoteTest extends TestCase
{
    protected $app;

    public function setUp(): void
    {
        $this->app = (new Routes())->get();
    }

    public function testLibraryGet() {
        $request = $this->createRequest('GET', '/api/quote');
        $response = $this->app->handle($request);
        $this->assertSame(200, $response->getStatusCode());
    }

    protected function createRequest(
        string $method,
        $uri,
        array $serverParams = []
    ): ServerRequestInterface {
        return (new ServerRequestFactory())->createServerRequest($method, $uri, $serverParams);
    }
}