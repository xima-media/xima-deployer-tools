<?php

namespace Deployer;

task('dev:release:reset', function () {
    /* get new version */
    $version = getNewVersion();

    info("checkout branch: " . get('dev_default_branch'));
    tabulaRasa(true);
    info("remove new branch: \"release-$version\"");
    runLocally("git branch -D \"release-$version\"");

    info("🧽 Reset back to " . get('dev_default_branch'));
})
    ->desc('Delete a new unreleased release');