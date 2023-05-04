<?php

namespace Deployer;

/**
 * Workaround for simplifying the autoloading process
 */
$vendorRoot = is_dir(__DIR__ . '/../../../../../vendor') ? __DIR__ . '/../../../../..' : __DIR__ . '/../../../..';

require_once($vendorRoot . '/vendor/sourcebroker/deployer-loader/autoload.php');
new \Xima\XimaDeployerTools\Drupal\Loader();

require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/autoload.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/drupal/config/set.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/drupal/task/deploy.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/drupal/task/deploy_cache.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/drupal/task/deploy_configuration.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/drupal/task/deploy_copy_files.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/drupal/task/deploy_database.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/drupal/task/deploy_files.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/drupal/task/deploy_logs.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/drupal/task/deploy_maintenance.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/drupal/task/deploy_permissions.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/drupal/task/deploy_rsync.php');
require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/drupal/task/deploy_translations.php');
// TODO: why not imported in t3 and symfony?
//require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/drupal/task/feature_sync_standalone.php');
//require_once($vendorRoot . '/vendor/xima/xima-deployer-tools/deployer/drupal/task/rollback.php');
