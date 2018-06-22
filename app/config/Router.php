<?php

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
        $this->app->get('/v1/group-checker/{steamId}', 'B3none\\Irrel\\Controller\\GroupCheck\\GroupCheckerController::check');
    }
}