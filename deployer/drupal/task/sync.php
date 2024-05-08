<?php

namespace Deployer;

// override dev command
task('dev:sync', function () {
  $source = get('db_sync_source_local');

  runExtended("drush sql:sync @$source @self --create-db -y");
})
  ->desc('Sync database with drush');
