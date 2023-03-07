<?php

namespace Deployer;

require_once(__DIR__ . '/deployer/functions.php');


/*
 * notification
 */
require_once(__DIR__ . '/deployer/notification/config/set.php');
require_once(__DIR__ . '/deployer/notification/task/ms_teams.php');
require_once(__DIR__ . '/deployer/notification/task/deploy_prod_notify.php');

/*
 * build
 */
require_once(__DIR__ . '/deployer/build/task/composer.php');
require_once(__DIR__ . '/deployer/build/task/assets.php');

/*
 * rsync
 */
require_once(__DIR__ . '/deployer/rsync/config/set.php');

/*
 * sync
 */
require_once(__DIR__ . '/deployer/sync/config/set.php');
require_once(__DIR__ . '/deployer/sync/task/database_backup.php');
