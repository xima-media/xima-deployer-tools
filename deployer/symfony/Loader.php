<?php

namespace Xima\XimaDeployerTools\Symfony;

use SourceBroker\DeployerLoader\Load;

class Loader
{
    public function __construct()
    {
        /** @noinspection PhpIncludeInspection */
        require_once 'recipe/common.php';

        new Load([
                ['path' => 'vendor/sourcebroker/deployer-instance/deployer'],
                ['path' => 'vendor/sourcebroker/deployer-extended/deployer'],
                [
                    'path' => 'vendor/xima/xima-deployer-tools/deployer/symfony',
                    'excludePattern' => '/example/'
                ]
            ]
        );
    }
}