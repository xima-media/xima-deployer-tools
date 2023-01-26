<?php

namespace Deployer;

task('typo3cms:cache:flushandwarmup', [
    'typo3cms:cache:flush',
    'typo3cms:cache:warmup'
]);

task('typo3cms:cache:flush', function () {
    $activeDir = test('[ -e {{deploy_path}}/release ]') ?
        get('deploy_path') . '/release' :
        get('deploy_path') . '/current';
    run('cd ' . $activeDir . ' &&  {{bin/php}} {{bin/typo3cms}} cache:flush');
});

task('typo3cms:cache:opcachereset', function () {
    // todo check if opcache is present on server and if opcache command is available
    $activeDir = test('[ -e {{deploy_path}}/release ]') ?
        get('deploy_path') . '/release' :
        get('deploy_path') . '/current';
    run('cd ' . $activeDir . ' &&  {{bin/php}} {{bin/typo3cms}} opcache:reset');
});

task('typo3cms:cache:warmup', function () {
    $activeDir = test('[ -e {{deploy_path}}/release ]') ?
        get('deploy_path') . '/release' :
        get('deploy_path') . '/current';
    run('cd ' . $activeDir . ' && {{bin/php}} {{bin/typo3cms}} cache:warmup');
});

task('typo3cms:cache:flushfrontend', function () {
    $activeDir = test('[ -e {{deploy_path}}/release ]') ?
        get('deploy_path') . '/release' :
        get('deploy_path') . '/current';
    run('cd ' . $activeDir . ' &&  {{bin/php}} {{bin/typo3cms}} cache:flush -g pages');
});
