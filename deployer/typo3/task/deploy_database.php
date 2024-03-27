<?php

namespace Deployer;

use Xima\XimaDeployerTools\Utility\EnvUtility;

task('deploy:database:update', function () {
    $activeDir = test('[ -e {{deploy_path}}/release ]') ?
        get('deploy_path') . '/release' :
        get('deploy_path') . '/current';
    runExtended('cd ' . $activeDir . ' && {{bin/php}} {{bin/typo3cms}} database:updateschema');
});

/**
 * Make Backup of DB in Prod before update
 */
task('database:backup')->select('prod');
before('deploy:database:update', 'database:backup');
set('sync_database_backup_config', __DIR__ . '/.deployment/db-sync-tool/backup-prod.yaml');


function getDatabasePasswordForTypo3(): string|bool
{
    $vars = EnvUtility::getRemoteEnvVars();
    if (array_key_exists('TYPO3_CONF_VARS__DB__Connections__Default__password', $vars)) {
        return $vars['TYPO3_CONF_VARS__DB__Connections__Default__password'];
    }
    return false;
}

function getDatabaseNameForTypo3(): string|bool
{
    $vars = EnvUtility::getRemoteEnvVars();
    if (array_key_exists('TYPO3_CONF_VARS__DB__Connections__Default__dbname', $vars)) {
        return $vars['TYPO3_CONF_VARS__DB__Connections__Default__dbname'];
    }
    return false;
}