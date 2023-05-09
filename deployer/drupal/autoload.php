<?php

namespace Deployer;

/**
 * Workaround for simplifying the autoloading process
 */
$vendorRoot = is_dir(__DIR__ . '/../../../../../vendor') ? __DIR__ . '/../../../../..' : __DIR__ . '/../../../..';

require_once($vendorRoot . '/vendor/sourcebroker/deployer-loader/autoload.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/autoload.php');
new \Xima\XimaDeployerTools\Drupal\Loader();
