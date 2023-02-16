<?php

namespace Deployer;

new \SourceBroker\DeployerExtendedSymfony5\Loader();

require_once(__DIR__ . '/config/set.php');

require_once(__DIR__ . '/task/deploy.php');