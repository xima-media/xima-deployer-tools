<?php

namespace Deployer;

// override dev command
task('dev:dump', function () {
  $dbDumpDir = run('pwd') . '/.deployment/tr-db-dumps/';

  run("mkdir -p $dbDumpDir");

  // cleanup beforehands: delete all dump files with the above naming scheme older than 7 days
  run("find $dbDumpDir -name '*.sql' -mtime +7 -delete");

  $dbDumpPath = $dbDumpDir . date('Y-m-d') . '.sql';

  runExtended('drush sql:dump --result-file=' . $dbDumpPath);
})
  ->desc('Sync database with drush');
