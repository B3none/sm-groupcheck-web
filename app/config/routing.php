<?php

$app->get('/v1/group-checker/{steamId}', 'B3none\\Irrel\\Controller\\GroupCheck\\GroupCheckerController::check');