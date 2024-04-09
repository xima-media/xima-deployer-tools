<?php

namespace Deployer;

task('dev:release:finish', function () {
    /* get new version */
    $version = getNewVersion();
    runLocally('git checkout ' . get('dev_default_branch'));
    runLocally("git merge \"release-$version\"");

    setVersion($version);
    commitVersion($version, VERSION_TYPE_RELEASE);

})
    ->desc('Merge release branch into default branch and release new version');