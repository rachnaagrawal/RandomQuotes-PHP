<?php
use Slim\Http\Environment;
use Slim\Http\Request;
use PHPUnit\Framework\TestCase;
class LibraryTestCase extends TestCase
{
    protected $app;
    public function setUp()
    {
        $this->app = (new Routes())->get();
    }
    public function testLibraryGet() {
        $env = Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/api/quote',
        ]);
        $req = Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 200);
    }
}