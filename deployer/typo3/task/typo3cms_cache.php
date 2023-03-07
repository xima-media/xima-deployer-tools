<?php

namespace Deployer;

task('deploy:cache:flush_and_warmup', [
    'typo3cms:cache:flush',
    'typo3cms:cache:warmup'
]);

task('typo3cms:cache:flush', function () {
    $activeDir = test('[ -e {{deploy_path}}/release ]') ?
        get('deploy_path') . '/release' :
        get('deploy_path') . '/current';
    run('cd ' . $activeDir . ' &&  {{bin/php}} {{bin/typo3cms}} cache:flush');
});

task('typo3cms:cache:warmup', function () {
    $activeDir = test('[ -e {{deploy_path}}/release ]') ?
        get('deploy_path') . '/release' :
        get('deploy_path') . '/current';
    run('cd ' . $activeDir . ' && {{bin/php}} {{bin/typo3cms}} cache:warmup');
});

//task('typo3cms:cache:flushfrontend', function () {
//    $activeDir = test('[ -e {{deploy_path}}/release ]') ?
//        get('deploy_path') . '/release' :
//        get('deploy_path') . '/current';
//    run('cd ' . $activeDir . ' &&  {{bin/php}} {{bin/typo3cms}} cache:flush -g pages');
//});
