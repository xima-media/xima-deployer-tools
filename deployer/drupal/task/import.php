<?php

namespace Deployer;

// override dev command
task('dev:import', function () {
  $dbDumpDir = run('pwd') . '/.deployment/tr-db-dumps/';

  $dbDumpPath = $dbDumpDir . date('Y-m-d') . '.sql';

  runExtended('drush sql:cli < ' . $dbDumpPath);
})
  ->desc('Sync database with drush');
