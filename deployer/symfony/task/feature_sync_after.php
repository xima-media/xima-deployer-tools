<?php

namespace Deployer;

task('feature:sync:after', [
    'deploy:database:update',
    'deploy:cache:clear'
]);