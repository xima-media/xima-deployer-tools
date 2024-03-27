<?php

namespace Deployer;

use Deployer\Exception\Exception;
use Symfony\Component\Console\Helper\Table;

task('develop:release:prepare', function () {
    /* get new version */
    if (is_null(input()->getOption('newVersion'))) {
        throw new Exception('Missing option "version" for new release', 1711458053);
    }
    $version = input()->getOption('newVersion');
    set('newVersion', $version);

    checkPreconditions();
//    $result = askChoice('Which steps do you want to perform?', [
//        'Tabula Rasa',
//        'New Release',
//        'Composer Update',
//        'Composer Update (CI)',
//        'npm Update'
//    ], null, true);
    tabulaRasa();
    startNewRelease();
    set('develop_tasks', ['tabula rasa', 'new release']);

    if (get('develop_composer_update_app')) {
        composerUpdate();
        add('develop_tasks', ['composer update']);
    }
    if (get('develop_composer_update_ci')) {
        composerUpdate('ci');
        add('develop_tasks', ['composer update (ci)']);
    }
    if (get('develop_npm_update')) {
        npmUpdate();
        add('develop_tasks', ['npm update']);
    }
    if (get('develop_npm_build')) {
        npmBuild();
        add('develop_tasks', ['npm build']);
    }
    if (get('develop_acceptance_test')) {
        acceptanceTest();
        add('develop_tasks', ['acceptance test']);
    }
    if (get('develop_php_qs')) {
        phpQs();
        add('develop_tasks', ['php qs']);
    }
    if (get('develop_npm_qs')) {
        phpQs();
        add('develop_tasks', ['npm qs']);
    }

    /* additional release tasks */
    get('develop_release_callback');

    info("Successfully prepared new release $version");
    $rows = [];
    foreach(get('develop_tasks') as $task) {
        $rows[] = [
            $task,
            '✔️'
        ];
    }
    (new Table(output()))
        ->setHeaderTitle($version)
        ->setHeaders(['Task', 'Status'])
        ->setRows($rows)
        ->render();

    warning("Please check your git log and verify all automated git commits before pushing them!");
    info("Don't forget to \"git push\"");
})
    ->select('alias=local')
    ->desc('Preparing a new release');


task('develop:release:reset', function () {
    /* get new version */
    if (is_null(input()->getOption('newVersion'))) {
        throw new Exception('Missing option "version" for new release', 1711458053);
    }
    $version = input()->getOption('newVersion');

    debug("checkout branch: " . get('develop_default_branch'));
    tabulaRasa(true);
    debug("remove new branch: \"release-$version\"");
    runLocally("git branch -D \"release-$version\"");

    info("Reset back to " . get('develop_default_branch'));
})
    ->select('alias=local')
    ->desc('Delete a new release');

function checkPreconditions() {
    $version = get('newVersion');
    if (!preg_match(get('develop_semver_regex'), $version, $matches)) {
        throw new Exception("Given version '$version' not matching semantic version constraints", 1711458465);
    }

    runLocally("composer validate --working-dir " . get('composer_path_app'));
}


function tabulaRasa(bool $force = false): void {
    info("tabula rasa");
    if (!$force) {
        $modifiedFiles = runLocally("git status -uno -s");
        if ($modifiedFiles) {
            throw new Exception("Please commit modified files before starting a new release", 1711460221);
        }

        debug("checkout branch: " . get('develop_default_branch'));
        runLocally('git pull');
        runLocally('git remote prune origin');
    }

    $additional = $force ? ' --force' : '';
    runLocally('git checkout ' . get('develop_default_branch') . $additional);

    /*  */
    debug("install dependencies");
    runLocally("composer install --working-dir " . get('composer_path_app'));

    /* additional tabula rasa tasks */
    get('develop_tabula_rasa_callback');

}

function startNewRelease(): void {
    info("start new release");
    $version = get('newVersion');
    /* new git branch */
    debug("create new branch: \"release-$version\"");
    runLocally("git checkout -b \"release-$version\"");

    /* new release version */
    debug("set new version: \"{$version}-RC\"");
    runLocally("composer config version {$version}-RC --working-dir " . get('composer_path_app'));
    runLocally("composer update nothing -q --no-scripts --no-plugins --working-dir " . get('composer_path_app'));
    runLocally("composer validate --working-dir " . get('composer_path_app'));

    debug("git commit");
    runLocally("git add " . get('composer_path_app') . "/composer.json " . get('composer_path_app') . "/composer.lock");
    runLocally("git commit -m \"" . get('develop_git_message_new_version') . " " . $version . "-RC\"");
}

function composerUpdate(string $mode = "app"): void {
    info("composer update ($mode)");

    debug("composer update");
    runLocally("composer update --working-dir " . get("composer_path_$mode") . " >> _tmp.txt 2>&1");
    // @ToDo: why is the complete output not be generated by the runLocally command, only getting the last 500 chars, so need to perform this workaround to collection dependency information
    $result = runLocally("cat _tmp.txt");
    runLocally("rm -f _tmp.txt");
    $message = get("develop_git_message_composer_update_$mode") . "\n\n";

    preg_match_all(get('develop_composer_regex'), $result, $matches);
    foreach ($matches[1] as $index => $package) {
        $message .= " - $package (" . $matches[2][$index] . ")\n";
    }

    debug("git commit");
    runLocally("git add .");
    runLocally("git commit -m \"$message\"");
}

function npmUpdate() {
    info("npm update");
    // @ToDo
}

function npmBuild() {
    info("npm build");
    // @ToDo
}

function acceptanceTest() {
    info("acceptance test");
    // @ToDo
}

function phpQs() {
    info("php qs");
    // @ToDo
}

function npmQs() {
    info("npm qs");
    // @ToDo
}