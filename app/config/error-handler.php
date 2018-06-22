<?php

$app->error(function (\Exception $e, $code) use ($app) {
    if ($code == 404) {
        return $app->json(['status' => 404, 'message' => $e->getMessage()]);
    }

    if ($app['debug']) {
        // In debug mode we want to get the regular error message
        return;
    }

    return new \Symfony\Component\HttpFoundation\Response('We are sorry, but something went terribly wrong.');
});