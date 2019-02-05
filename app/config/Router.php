<?php

use B3none\GroupCheck\V1\Controllers\GroupCheckerController;

class Router
{
    /**
     * @var \Silex\Application
     */
    protected $app;

    public function __construct(\Silex\Application $app)
    {
        $this->app = $app;
    }

    public function buildRoutes()
    {
        $this->app->get('/v1/group-checker/{steamId}', GroupCheckerController::class.'::check');
    }
}