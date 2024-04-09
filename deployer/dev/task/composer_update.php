<?php

namespace Deployer;


task('dev:release:composer_update_app', function () {
    if (!checkStepIsEnabled('dev:release:composer_update_app')) { return; }
    composerUpdate();
})->desc('Update composer dependencies for app');

task('dev:release:composer_update_ci', function () {
    if (!checkStepIsEnabled('dev:composer_update_ci:composer_update_ci')) { return; }
    composerUpdate('ci');
})->desc('Update composer dependencies for ci');

function composerUpdate(string $mode = "app"): void {
    info("composer update ($mode)");
    runLocally("composer update --working-dir " . get("composer_path_$mode") . " >> _tmp.txt 2>&1");
    // @ToDo: why is the complete output not be generated by the runLocally command, only getting the last 500 chars, so need to perform this workaround to collection dependency information
    $result = runLocally("cat _tmp.txt");
    runLocally("rm -f _tmp.txt");
    $message = get("dev_git_message_composer_update_$mode") . "\n\n";

    preg_match_all(get('dev_composer_regex'), $result, $matches);
    foreach ($matches[1] as $index => $package) {
        $message .= " - $package (" . $matches[2][$index] . ")\n";
    }

    info($message);
    info("commit updates");
    commit($message);
}
