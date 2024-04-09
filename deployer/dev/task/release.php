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
    'dev:release:qa:php',
    'dev:release:qa:npm',
])->desc('Defines the single steps for the release preparation');

task('dev:release:pre', function () {
    /* get new version */
    getNewVersion();

    /* check if everything is clear */
    runLocally("composer validate --working-dir " . get('composer_path_app'));

    /* select steps to execute */
    if (!input()->getOption('no-interaction')) {
        info("Which steps of the task \"dev:release:steps\" shall be executed? (hint: skip the selection with \"--no-interaction\")");

        foreach (getSubTask('dev:release:steps') as $step) {
            $result = ask("$step", "yes");
            if ($result !== "yes" && $result !== "y") {
                task($step)->disable();
                warning("Task \"$step\" disabled");
            }
        }
    }
})->desc('Prepares the release process');

task('dev:release:post', function () {
    $version = get('newVersion');
    info("Successfully prepared new release $version");
    $rows = [];
    foreach(getSubTask('dev:release') as $task) {
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
    info("💡Don't forget to \"git push\"");
})->desc('Finish the release preparation');

function getNewVersion(): string {
    if (is_null(input()->getOption('newVersion'))) {
        $version = ask("New release version?", guessNextMinorVersion());
    } else {
        $version = input()->getOption('newVersion');
    }

    if (!preg_match(get('dev_semver_regex'), $version)) {
        throw new Exception("Given version '$version' not matching semantic version constraints", 1711458465);
    }

    set('newVersion', $version);
    return $version;
}

function guessNextMinorVersion(): string|bool
{
    try {
        $lastTag = preg_replace('/^v/', '', runLocally('git describe --tags --abbrev=0'));
        $lastTagParts = explode('.', $lastTag);
        if (!preg_match(get('dev_semver_regex'), $lastTag)) {
            return false;
        }
        $lastTagParts[1] = (int)$lastTagParts[1] + 1;
        $lastTagParts[2] = 0;
        return implode('.', $lastTagParts);
    } catch (Exception) {
        return false;
    }

}

function getSubTask(string $task): array
{
    $task = Deployer::get()->tasks->get($task);
    if ($task && $task->isEnabled()) {
        if ($task instanceof GroupTask) {
            $subTasks = [];
            foreach ($task->getGroup() as $subtask) {
                $subTasks = array_merge($subTasks, getSubTask($subtask));
            }
            return $subTasks;
        } else {
            return [$task->getName()];
        }
    }
    return [];
}