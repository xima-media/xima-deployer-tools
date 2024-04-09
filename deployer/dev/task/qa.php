<?php

namespace Deployer;

task('dev:release:qa:php', function () {
    runLocally("composer check --working-dir " . get('composer_path_app'));
})
    ->desc('QA php');

task('dev:release:qa:npm', function () {
    runLocally("npm run lint ---prefix " . get('npm_path_app'));
})
    ->desc('QA npm');