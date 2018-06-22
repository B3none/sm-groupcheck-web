<?php

namespace B3none\Irrel\Controller;

use B3none\Irrel\Silex\Application;
use B3none\SteamGroupChecker\Client as GroupChecker;
use B3none\SteamIDConverter\Client as IDConverter;

class SteamGroupController
{
    /**
     * @var GroupChecker
     */
    protected $groupChecker;

    /**
     * @var IDConverter
     */
    protected $idConverter;

    /**
     * @var Application
     */
    protected $app;

    /**
     * SteamGroupController constructor.
     * @param Application $app
     * @param IDConverter $idConverter
     * @param GroupChecker $groupChecker
     */
    public function __construct(Application $app, IDConverter $idConverter, GroupChecker $groupChecker)
    {
        $this->groupChecker = $groupChecker;
        $this->idConverter = $idConverter;
        $this->app = $app;
    }

    /**
     * @param string $steamId
     * @return mixed
     */
    public function check(string $steamId)
    {
        if (substr(strtolower($steamId), 0, 6) == "steam_") {
            $steamId = $this->idConverter->createFromSteamID(urldecode($steamId));
            $steamId = $steamId->getSteamID64();
        }

        $results = $this->groupChecker->detect($steamId, [
           'https://steamcommunity.com/groups/irrel'
        ]);

        return $this->app->json([
            'grantAccess' => $results->shouldGrantAccess(),
            'rejectReason' => $results->getRejectReason()
        ]);
    }
}