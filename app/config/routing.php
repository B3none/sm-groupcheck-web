<?php

$app->get('/v1/group-checker/{steamId}', 'steamGroupController:check');