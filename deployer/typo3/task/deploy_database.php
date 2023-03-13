<?php

namespace Deployer;

task('deploy:database:update', function () {
    $activeDir = test('[ -e {{deploy_path}}/release ]') ?
        get('deploy_path') . '/release' :
        get('deploy_path') . '/current';
    run('cd ' . $activeDir . ' && {{bin/php}} {{bin/typo3cms}} database:updateschema');
});
