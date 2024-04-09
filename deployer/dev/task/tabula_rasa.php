<?php

namespace Deployer;

use Deployer\Exception\Exception;

task('dev:release:tabula_rasa', function () {
    tabulaRasa();
})
    ->desc('Tabula rasa');

function tabulaRasa(bool $force = false): void {
    info("[step] tabula rasa");
    if (!$force) {
        $modifiedFiles = runLocally("git status -uno -s");
        if ($modifiedFiles) {
            throw new Exception("Please commit modified files before starting a new release", 1711460221);
        }

        debug("checkout branch: " . get('dev_default_branch'));
        runLocally('git pull');
        runLocally('git remote prune origin');
    }

    $additional = $force ? ' --force' : '';
    runLocally('git checkout ' . get('dev_default_branch') . $additional);
    runLocally('git reset');

    /*  */
    debug("install dependencies");
    runLocally("composer install --working-dir " . get('composer_path_app'));

    /* additional tabula rasa tasks */
    get('dev_tabula_rasa_callback');
}