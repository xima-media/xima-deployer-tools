<?php

namespace Deployer;

task('typo3cms:setup', function () {
    $activeDir = test('[ -e {{deploy_path}}/release ]') ?
        get('deploy_path') . '/release' :
        get('deploy_path') . '/current';
    run('cd ' . $activeDir . ' &&  {{bin/php}} {{bin/typo3cms}} install:fixfolderstructure && {{bin/php}} {{bin/typo3cms}} install:extensionsetupifpossible');
});
