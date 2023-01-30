<?php

namespace Deployer;

require_once('feature_init.php');


task('feature:sync', function () {

    if ((has('feature_setup') && !get('feature_setup')) || !input()->hasOption('feature')) return;

    $feature = initFeature();

    // ToDo: try https://github.com/sourcebroker/deployer-extended-database
    runLocally("{{db_sync_tool}} -f {{feature_sync_config}} --target-path {{feature_sync_target_path}} -y");
    info("feature branch <fg=magenta;options=bold>$feature</> was sucessfully synced");

})->desc('Sync a feature branch');
