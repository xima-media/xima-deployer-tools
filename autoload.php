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
require_once(__DIR__ . '/deployer/build/autoload.php');

/*
 * rsync
 */
require_once(__DIR__ . '/deployer/rsync/config/set.php');

/*
 * sync
 */
require_once(__DIR__ . '/deployer/sync/config/set.php');
require_once(__DIR__ . '/deployer/sync/task/database_backup.php');

/*
 * security
 */
require_once(__DIR__ . '/deployer/security/config/set.php');
require_once(__DIR__ . '/deployer/security/config/options.php');
require_once(__DIR__ . '/deployer/security/task/security.php');

/*
 * debug
 */
require_once(__DIR__ . '/deployer/debug/config/set.php');
require_once(__DIR__ . '/deployer/debug/task/debug_db.php');
require_once(__DIR__ . '/deployer/debug/task/debug_ssh.php');
require_once(__DIR__ . '/deployer/debug/task/debug_log_app.php');