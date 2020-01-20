<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require '../../vendor/autoload.php';
$app = new \Slim\App();

$app->get('/quote', function (Request $request, Response $response) {
    $response->withStatus(200)->write("Welcome to the Adroit Library Demo.");
    return $response;
});

$app->run();
