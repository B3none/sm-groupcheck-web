<?php

$app->error(function (\Exception $e, $code) use ($app) {
    if ($code == 404) {
        return $app['twig']->render('homepage.twig');
    }

    if ($app['debug']) {
        // in debug mode we want to get the regular error message
        return;
    }

    return new \Symfony\Component\HttpFoundation\Response('We are sorry, but something went terribly wrong.');
});