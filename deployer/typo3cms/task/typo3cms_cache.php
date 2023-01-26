<?php

namespace Deployer;

task('typo3cms:cache:flushandwarmup', function () {
    $activeDir = test('[ -e {{deploy_path}}/release ]') ?
        get('deploy_path') . '/release' :
        get('deploy_path') . '/current';
    run('cd ' . $activeDir . ' &&  {{bin/php}} {{bin/typo3cms}} cache:flush && {{bin/php}} {{bin/typo3cms}} opcache:reset && {{bin/php}} {{bin/typo3cms}} cache:warmup');
});

task('typo3cms:cache:flushfrontend', function () {
    $activeDir = test('[ -e {{deploy_path}}/release ]') ?
        get('deploy_path') . '/release' :
        get('deploy_path') . '/current';
    run('cd ' . $activeDir . ' &&  {{bin/php}} {{bin/typo3cms}} cache:flush -g pages');
});
