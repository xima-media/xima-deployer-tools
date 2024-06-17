<?php

namespace Deployer;

task('dev:import', function () {
    $target = runLocally('git branch --show-current');

    $dbDumpDir = get('dev_tr_db_dump_dir');
    $dbDumpFilename = getRecentDatabaseCacheDumpFilename();

    $dbSyncToolSync = get('dev_db_sync_tool_default_sync');

    info("sync database from remote: $target");

    $dbSyncToolConfigPath = get('dev_db_sync_tool_config_path');
    runLocally("db_sync_tool -f $dbSyncToolConfigPath/$dbSyncToolSync -y -i $dbDumpDir/$dbDumpFilename.sql", ['real_time_output' => true]);
})
    ->desc('Sync database with drush');
