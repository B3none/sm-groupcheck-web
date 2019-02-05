<?php

namespace B3none\GroupCheck\V1\Controllers;

use B3none\SteamGroupChecker\Client as GroupChecker;
use B3none\SteamIDConverter\Client as IDConverter;
use Silex\Application;

class GroupCheckerController
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
     * GroupCheckerController constructor.
     */
    public function __construct()
    {
        $this->groupChecker = GroupChecker::create();
        $this->idConverter = IDConverter::create();
    }

    /**
     * @param Application $app
     * @param string $steamId
     * @return mixed
     */
    public function check(Application $app, string $steamId)
    {
        if (substr(strtolower($steamId), 0, 6) == "steam_") {
            $steamId = $this->idConverter->createFromSteamID(urldecode($steamId));
            $steamId = $steamId->getSteamID64();
        } else if (!(int)$steamId >= 76561197960265728) {
            return $app->json([
                'grantAccess' => false,
                'rejectReason' => "None"
            ]);
        }

        $results = $this->groupChecker->detect($steamId, [
           'https://steamcommunity.com/groups/meloncartel'
        ]);

        return $app->json([
            'grantAccess' => $results->shouldGrantAccess(),
            'rejectReason' => $results->getRejectReason()
        ]);
    }
}
