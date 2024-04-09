<?php

namespace Deployer;

task('dev:release:qa:php', function () {
    if (in_array('dev:release:qa:php', get('disabled_tasks'))) { return; }
    runLocally("composer check --working-dir " . get('composer_path_app'));
})
    ->desc('QA php');

task('dev:release:qa:npm', function () {
    if (in_array('dev:release:qa:npm', get('disabled_tasks'))) { return; }
    runLocally("npm run lint ---prefix " . get('npm_path_app'));
})
    ->desc('QA npm');