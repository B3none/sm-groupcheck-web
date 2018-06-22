<?php

$startTime = microtime(true);
require __DIR__ . '/../vendor/autoload.php';

// Initialize Application
$app = new \Silex\Application([
    'debug' => true
//    'twig.path' => __DIR__ . '/../src/views'
]);

// Map routes to controllers
require __DIR__ . '/config/Router.php';
(new Router($app))->buildRoutes();

// Add error handling.
require __DIR__ . '/config/error-handler.php';

return $app;
