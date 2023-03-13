<?php

namespace Deployer;

task('deploy:cache:clear_and_warmup', [
    'deploy:cache:clear',
    'deploy:cache:warmup'
]);

task('deploy:cache:clear', function () {
    $activeDir = test('[ -e {{deploy_path}}/release ]') ?
        get('deploy_path') . '/release' :
        get('deploy_path') . '/current';
    run('cd ' . $activeDir . ' &&  {{bin/php}} {{bin/typo3cms}} cache:flush');
});

task('deploy:cache:warmup', function () {
    $activeDir = test('[ -e {{deploy_path}}/release ]') ?
        get('deploy_path') . '/release' :
        get('deploy_path') . '/current';
    run('cd ' . $activeDir . ' && {{bin/php}} {{bin/typo3cms}} cache:warmup');
});

task('deploy:warmup_frontend', function () {
    foreach (get('public_urls') as $publicUrl) {
        run('curl --insecure ' . $publicUrl);
    }
});

//task('typo3cms:cache:flushfrontend', function () {
//    $activeDir = test('[ -e {{deploy_path}}/release ]') ?
//        get('deploy_path') . '/release' :
//        get('deploy_path') . '/current';
//    run('cd ' . $activeDir . ' &&  {{bin/php}} {{bin/typo3cms}} cache:flush -g pages');
//});
