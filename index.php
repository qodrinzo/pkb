<?php
require 'vendor/autoload.php';

$app = new \Slim\App;

// Define app routes
$app->get('/', function ($request, $response, $args) {
    return $response->write("Hello Buddy");
});

// Run app
$app->run();
