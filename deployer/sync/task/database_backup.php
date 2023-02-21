<?php

namespace Deployer;

task('database:backup', function () {

    $optionalVerbose = isVerbose() ? '-v' : '';

    info('Generating a database backup');
    runLocally("{{db_sync_tool}} -f {{sync_database_backup_config}} -y $optionalVerbose");

})
    ->once()
    ->desc('Generating a database backup')
;
