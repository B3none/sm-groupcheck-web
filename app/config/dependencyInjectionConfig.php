<?php

$app['idConverter'] = $app->share(
    function () use ($app) {
        return \B3none\SteamIDConverter\Client::create();
    }
);

$app['groupChecker'] = $app->share(
    function () use ($app) {
        return \B3none\SteamGroupChecker\Client::create();
    }
);

$app['steamGroupController'] = $app->share(
    function () use ($app) {
        return new \B3none\Irrel\Controller\SteamGroupController($app, $app['idConverter'], $app['groupChecker']);
    }
);