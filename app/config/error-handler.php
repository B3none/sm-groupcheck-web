<?php

$app->error(function (\Exception $e, $code) use ($app) {
    return $app->json(['status' => $code, 'message' => $e->getMessage()]);
});