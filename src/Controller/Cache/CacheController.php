<?php

namespace B3none\MelonCartel\Controller\Cache;


class CacheController
{
    const CACHE_DIR = "/tmp/MelonCartel/cache";

    public function setCache(string $id, array $cacheValue)
    {
        if (!is_dir(self::CACHE_DIR)) {
            mkdir(self::CACHE_DIR);
        }

        $cacheFile = self::CACHE_DIR . "/$id.json";
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }

        $cacheValue['last-modified'] = time();

        $file = fopen($cacheFile, "w");
        fwrite($file, json_encode($cacheValue, JSON_PRETTY_PRINT));
        fclose($file);
    }

    public function hasCache(string $id) : bool
    {
        $cacheFile = self::CACHE_DIR . "/$id.json";
        return file_exists($cacheFile);
    }

    public function isFreshEnough(string $id, int $minutes = 30) : bool
    {
        $cachedData = $this->getCache($id);

        if (!$cachedData) {
            throw new \Exception("No cache file found.");
        }
        $difference = $cachedData['last-modified'] - time();
        $difference = ($difference / 1000) / 60;

        return round($difference <= $minutes);
    }

    public function getCache(string $id) : array
    {
        $cacheFile = self::CACHE_DIR . "/$id.json";
        return json_decode(file_get_contents($cacheFile), true);
    }
}