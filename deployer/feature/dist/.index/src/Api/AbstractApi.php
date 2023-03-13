<?php

namespace Xima\FeatureIndex\Api;

use Xima\FeatureIndex\Model\Entry;
use Xima\FeatureIndex\Service\IOService;
use Xima\FeatureIndex\Utility\EntryUtility;

abstract class AbstractApi
{

    const CACHE_PATH = __DIR__ . '/../../var/cache/';
    const CACHE_LIFETIME = 300;

    protected function getCache(string $issue) {
        $ioService = new IOService();

        $ioService->directoryExists(self::CACHE_PATH, true);

        $filePath = self::CACHE_PATH . $issue;
        if (file_exists($filePath)) {
            $createDate = filectime($filePath);

            if (($createDate + self::CACHE_LIFETIME) > time()) {
                return json_decode(file_get_contents($filePath),true);
            }
        }
        return false;
    }

    protected function setCache(string $issue, string $content) {
        $ioService = new IOService();
        $ioService->directoryExists(self::CACHE_PATH, true);
        $filePath = self::CACHE_PATH . $issue;

        umask(0002);
        // todo: cleanup
        file_put_contents($filePath, $content);
    }
}