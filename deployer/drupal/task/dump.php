<?php

namespace Deployer;

// override dev command
task('dev:dump', function () {
  $dbDumpDir = getRecentDatabaseCacheDumpDirectory();

  run("mkdir -p $dbDumpDir");

  // cleanup beforehand: delete all dump files with the above naming scheme older than 7 days
  cleanUpDatabaseCacheDumps();

  runExtended('drush sql:dump --result-file=' . getRecentDatabaseCacheDumpPath());
})
  ->desc('Sync database with drush');
