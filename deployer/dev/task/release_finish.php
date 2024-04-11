<?php

namespace Deployer;

task('dev:release:finish', function () {
    $version = getNewVersion();
    runLocally('git checkout ' . get('dev_default_branch'));
    runLocally("git merge \"release-$version\"");

    setVersion($version);
    commitVersion($version, VERSION_TYPE_RELEASE);
    runLocally("git tag -a \"v{$version}\" -m \"{$version}\"");

    warning("⚠️ Please check your git log and verify all automated git commits before pushing them!");
    info("ℹ️ Don't forget to \"git push\"");

})
    ->desc('Merge release branch into default branch and release new version');