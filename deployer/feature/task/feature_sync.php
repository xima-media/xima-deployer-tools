<?php

namespace Deployer;

require_once('feature_init.php');


task('feature:sync', function () {

    if ((has('initial_deployment') && !get('initial_deployment')) || !input()->hasOption('feature')) return;

    $feature = input()->getOption('feature');
    set('feature', $feature);
    runLocally("{{db_sync_tool}} -f {{feature_sync_config}} --target-path {{feature_sync_target_path}} -y");
    info("feature branch <fg=magenta;options=bold>$feature</> was sucessfully synced");

})->desc('Sync a feature branch');
