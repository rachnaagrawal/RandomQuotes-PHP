<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

class Routes
{
    private $app;
    public function __construct()
    {
        AppFactory::setSlimHttpDecoratorsAutomaticDetection(false);
        ServerRequestCreatorFactory::setSlimHttpDecoratorsAutomaticDetection(false);

        $app = AppFactory::create();

        $app->get('/api/quote', function (Request $request, Response $response) {
            $authors = file(__DIR__ . "/authors.txt", FILE_IGNORE_NEW_LINES);
            $quotes = file(__DIR__ . "/quotes.txt", FILE_IGNORE_NEW_LINES);
            $randomIndex = rand(0, count($authors) - 1);

            $response->getBody()->write("{\"quote\": \"" . $quotes[$randomIndex] . "\", " .
                "\"author\": \"" . $authors[$randomIndex] . "\", " .
                "\"appVersion\": \"1.0.0\", " .
                "\"environmentName\": \"" . (getenv('ENVIRONMENT_NAME') ?: 'Local') . "\" " .
                "}");
            return $response;
        });

        $app->get('/fpm-ping', function (Request $request, Response $response) {
            $response->withStatus(200);
            return $response;
        });

        $this->app = $app;
    }

    public function get()
    {
        return $this->app;
    }
}