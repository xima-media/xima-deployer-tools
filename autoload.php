<?php

namespace Deployer;

require_once(__DIR__ . '/deployer/functions.php');

require_once(__DIR__ . '/deployer/feature/config/options.php');
require_once(__DIR__ . '/deployer/feature/config/set.php');

require_once(__DIR__ . '/deployer/feature/task/feature_init.php');
require_once(__DIR__ . '/deployer/feature/task/feature_stop.php');
require_once(__DIR__ . '/deployer/feature/task/feature_notify.php');
require_once(__DIR__ . '/deployer/feature/task/feature_sync.php');
require_once(__DIR__ . '/deployer/feature/task/feature_list.php');
require_once(__DIR__ . '/deployer/feature/task/feature_index.php');
require_once(__DIR__ . '/deployer/feature/task/feature_cleanup.php');

require_once(__DIR__ . '/deployer/typo3cms/task/typo3cms_cache.php');
require_once(__DIR__ . '/deployer/typo3cms/task/typo3cms_database.php');
require_once(__DIR__ . '/deployer/typo3cms/task/typo3cms_setup.php');

require_once(__DIR__ . '/deployer/notification/config/set.php');
require_once(__DIR__ . '/deployer/notification/task/ms_teams.php');

