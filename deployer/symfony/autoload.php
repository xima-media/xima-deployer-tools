<?php

namespace Deployer;

require_once('vendor/sourcebroker/deployer-instance/deployer');
require_once('vendor/sourcebroker/deployer-extended/deployer');

require_once(__DIR__ . '/config/set.php');

require_once(__DIR__ . '/task/deploy_cache_clear.php.php');
require_once(__DIR__ . '/task/deploy_cache_warmup.php');
require_once(__DIR__ . '/task/deploy_database_update.php');

require_once(__DIR__ . '/task/deploy.php');