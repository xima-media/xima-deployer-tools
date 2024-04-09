<?php

namespace Deployer;

use Deployer\Exception\Exception;
use Deployer\Task\GroupTask;
use Symfony\Component\Console\Helper\Table;

task('dev:release', [
    'dev:release:pre',
    'dev:release:tabula_rasa',
    'dev:release:start_new_release',
    'dev:release:steps',
    'dev:release:post'
])->desc('Generate a new release');

task('dev:release:steps', [
    'dev:release:composer_update_app',
    'dev:release:composer_update_ci',
    'dev:release:npm_update',
    'dev:release:qa:php',
    'dev:release:qa:npm',
    'dev:release:test:acceptance',
])->desc('Defines the single steps for the release preparation');

task('dev:release:pre', function () {
    /* get new version */
    getNewVersion();

    /* check if everything is clear */
    info("🔍 Checking composer.json");
    runLocally("composer validate --working-dir " . get('composer_path_app'));

    /* select steps to execute */
    if (!input()->getOption('no-interaction')) {
        info("Which steps of the task \"dev:release:steps\" shall be executed? (hint: skip the selection with \"--no-interaction\")");

        foreach (getSubTask('dev:release:steps') as $step) {
            $result = ask("$step", "yes");
            if ($result !== "yes" && $result !== "y") {
                // disabling a task on runtime does not work
                // task($step)->disable();
                add('disabled_tasks', [$step]);
                warning("Task \"$step\" disabled");
            }
        }
    }
})->desc('Prepares the release process');

task('dev:release:post', function () {
    $version = get('newVersion');
    info("🚀 Successfully prepared new release $version");
    $rows = [];
    foreach(getSubTask('dev:release') as $task) {
        if (is_array(get('disabled_tasks')) && in_array($task, get('disabled_tasks'))) {
            $rows[] = [
                $task,
                '⏭️'
            ];
            continue;
        }
        $rows[] = [
            $task,
            '✅️'
        ];
    }
    (new Table(output()))
        ->setHeaderTitle($version)
        ->setHeaders(['Task', 'Status'])
        ->setRows($rows)
        ->render();

    warning("⚠️ Please check your git log and verify all automated git commits before pushing them!");
    foreach(get('dev_additional_warnings') as $warning) {
        warning($warning);
    }
    info("ℹ️ Don't forget to \"git push\"");
    info("💡Use the command \"dep dev:release:finish\" to finish the release process after merging features and bug fixes.");
})->desc('Finish the release preparation');
