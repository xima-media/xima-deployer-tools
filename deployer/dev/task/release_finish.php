<?php

namespace Deployer;

task('dev:release:finish', function () {
    /* get new version */
    $version = getNewVersion();
    // @ToDo
})
    ->desc('Merge release branch into default branch and release new version');