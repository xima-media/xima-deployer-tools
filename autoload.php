<?php

namespace Deployer;

require_once(__DIR__ . '/deployer/functions.php');

/*
 * typo3cms
 */
require_once(__DIR__ . '/deployer/typo3cms/config/set.php');

require_once(__DIR__ . '/deployer/typo3cms/task/typo3cms_cache.php');
require_once(__DIR__ . '/deployer/typo3cms/task/typo3cms_database.php');
require_once(__DIR__ . '/deployer/typo3cms/task/typo3cms_setup.php');

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
 * deploy
 */
require_once(__DIR__ . '/deployer/deploy/task/deploy.php');
require_once(__DIR__ . '/deployer/deploy/task/rollback.php');

/*
 * rsync
 */
require_once(__DIR__ . '/deployer/rsync/config/set.php');
