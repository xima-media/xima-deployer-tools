<?php

namespace Deployer;

task('dev:release:test:acceptance', function () {
    if (in_array('dev:release:test:acceptance', get('disabled_tasks'))) { return; }
    info('ToDo');
})
    ->desc('Run acceptance tests');