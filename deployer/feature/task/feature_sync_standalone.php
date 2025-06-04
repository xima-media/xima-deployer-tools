<?php

namespace Deployer;

/**
 * This is an extendable task.
 */
task('feature:sync:standalone', [
    'feature:sync',
    'deploy:database:update',
    'deploy:cache:clear'
]);