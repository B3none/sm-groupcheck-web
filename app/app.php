<?php

include(__DIR__ . '/../vendor/autoload.php');

// Initialize Application
$app = new \Silex\Application([
    'debug' => $_SERVER['SERVER_NAME'] === 'localhost'
]);

// Map routes to controllers
include(__DIR__ . '/config/Router.php');
(new Router($app))->buildRoutes();

// Add error handling.
include(__DIR__ . '/config/error-handler.php');

return $app;
