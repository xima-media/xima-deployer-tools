<?php

namespace Deployer;

/**
 * This task is optional and only relevant in combination with the feature branch deployment
 */
task('feature:sync:after', [
    'deploy:database:update',
    'deploy:cache:clear'
]);