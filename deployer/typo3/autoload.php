<?php

namespace Deployer;

/**
 * Workaround for simplifying the autoloading process
 */
$vendorRoot = is_dir(__DIR__ . '/../../../../../vendor') ? __DIR__ . '/../../../../..' : __DIR__ . '/../../../..';

require_once($vendorRoot . '/vendor/sourcebroker/deployer-loader/autoload.php');
new \Xima\XimaDeployerTools\TYPO3\Loader();

require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/autoload.php');

require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/typo3/functions.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/typo3/config/set.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/typo3/task/deploy.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/typo3/task/deploy_cache.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/typo3/task/deploy_database.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/typo3/task/deploy_setup.php');

