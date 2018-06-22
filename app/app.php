<?php

$startTime = microtime(true);
require __DIR__ . '/../vendor/autoload.php';

// Initialize Application
$app = new \B3none\Irrel\Silex\Application([
    'debug' => false,
    'twig.path' => __DIR__ . '/../src/views',
    'twig.options' => [
        // TODO disable for now until we fix production bug
        //'cache' => __DIR__ . '/cache/twig',
    ],
]);

// Insert DI config
require __DIR__ . '/config/dependencyInjectionConfig.php';

// Map routes to controllers
require __DIR__ . '/config/routing.php';

// Add error handling.
require __DIR__ . '/config/error-handler.php';

return $app;
