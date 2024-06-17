<?php

namespace Deployer;

// override dev command
task('dev:dump', function () {
  $dbDumpDir = getRecentDatabaseCacheDumpDirectory();

  run("mkdir -p $dbDumpDir");

  // cleanup beforehand: delete all dump files with the above naming scheme older than 7 days
  cleanUpDatabaseCacheDumps();

  $target = runLocally('git branch --show-current');

  $dbSyncToolSync = get('dev_db_sync_tool_default_sync');

  $dbSyncToolOriginPath = str_replace('<feature>', $target, get('dev_db_sync_tool_origin_path'));
  $additionalOptions = "--origin-path $dbSyncToolOriginPath";

  info("sync database from remote: $target");

  $dbSyncToolConfigPath = get('dev_db_sync_tool_config_path');
//  runLocally("db_sync_tool -f $dbSyncToolConfigPath/$dbSyncToolSync -y $additionalOptions", ['real_time_output' => true]);
  runLocally("db_sync_tool -y $additionalOptions", ['real_time_output' => true]);
  info("💽 Database from $target synced successfully");

  runExtended('drush sql:dump --result-file=' . getRecentDatabaseCacheDumpPath());
})
  ->desc('Sync database with drush');
