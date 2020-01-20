<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require '../../vendor/autoload.php';
$app = new \Slim\App();

$app->get('/quote', function (Request $request, Response $response) {
    $authors = file("authors.txt", FILE_IGNORE_NEW_LINES);
    $quotes = file("quotes.txt", FILE_IGNORE_NEW_LINES);
    $randomIndex = rand(0,count($authors) - 1);

    $response->withStatus(200)->write("{\"quote\": \"" . $quotes[$randomIndex] . "\", " .
        "\"author\": \"" . $authors[$randomIndex] . "\", " .
        "\"appVersion\": \"1.0.0\", " .
        "\"environmentName\": \"" . getenv('ENVIRONMENT_NAME') . "\" " .
        "}");
    return $response;
});

$app->run();
