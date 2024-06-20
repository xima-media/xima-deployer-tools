<?php

namespace Deployer;

// override dev command
task('dev:import', function () {
    runExtended('drush sql:cli < ' . getRecentDatabaseCacheDumpPath());
})
    ->desc('Sync database with drush');
