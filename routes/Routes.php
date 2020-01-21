<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
class Routes
{
    private $app;
    public function __construct()
    {
        $app = new \Slim\App();

        $app->get('/api/quote', function (Request $request, Response $response) {
            $authors = file(__DIR__ . "/authors.txt", FILE_IGNORE_NEW_LINES);
            $quotes = file(__DIR__ . "/quotes.txt", FILE_IGNORE_NEW_LINES);
            $randomIndex = rand(0, count($authors) - 1);

            $response->withStatus(200)->write("{\"quote\": \"" . $quotes[$randomIndex] . "\", " .
                "\"author\": \"" . $authors[$randomIndex] . "\", " .
                "\"appVersion\": \"1.0.0\", " .
                "\"environmentName\": \"" . (getenv('ENVIRONMENT_NAME') ?: 'Local') . "\" " .
                "}");
            return $response;
        });

        $this->app = $app;
    }

    public function get()
    {
        return $this->app;
    }
}