<?php

namespace Deployer;

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
