<?php

namespace Deployer;

require_once('feature_init.php');


task('feature:sync', function () {

    if ((has('feature_setup') && !get('feature_setup')) || !input()->getOption('feature')) return;

    $feature = initFeature();
    $optionalVerbose = isVerbose() ? '-v' : '';

    // ToDo: try https://github.com/sourcebroker/deployer-extended-database
    info('Synching database');
    runLocally("{{db_sync_tool}} -f {{feature_sync_config}} --target-path {{feature_sync_target_path}} -y $optionalVerbose");
    info('Synching files');
    runLocally("{{file_sync_tool}} -f {{feature_sync_config}} --files-target {{feature_sync_target_path_files}} $optionalVerbose");
    info("feature branch <fg=magenta;options=bold>$feature</> was successfully synced");

})
    ->select('type=feature-branch-deployment')
    ->desc('Sync a feature branch')
;
