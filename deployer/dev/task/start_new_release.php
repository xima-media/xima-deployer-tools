<?php

namespace Deployer;


task('dev:release:start_new_release', function () {
    info("[step] start new release");
    $version = get('newVersion');

    /* new git branch */
    debug("create new branch: \"release-$version\"");
    runLocally("git checkout -b \"release-$version\"");

    /* new release version */
    debug("set new version: \"{$version}-RC\"");
    runLocally("composer config version {$version}-RC --working-dir " . get('composer_path_app'));
    runLocally("composer update nothing -q " . get('composer_app_release_options') . " --working-dir " . get('composer_path_app'));
    runLocally("composer validate --working-dir " . get('composer_path_app'));

    debug("git commit");
    runLocally("git add " . get('composer_path_app') . "/composer.json " . get('composer_path_app') . "/composer.lock");
    runLocally("git commit --no-verify -m \"" . get('dev_git_message_new_version') . " " . $version . "-RC\"");
})
    ->desc('Start a new release');