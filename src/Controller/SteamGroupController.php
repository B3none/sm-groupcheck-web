<?php

namespace B3none\Irrel\Controller;

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
     * SteamGroupController constructor.
     * @param GroupChecker $groupChecker
     * @param IDConverter $idConverter
     */
    public function __construct(GroupChecker $groupChecker, IDConverter $idConverter)
    {
        $this->groupChecker = $groupChecker;
        $this->idConverter = $idConverter;
    }

    /**
     * @param string $steamId
     * @return mixed
     */
    public function check(string $steamId)
    {

    }
}