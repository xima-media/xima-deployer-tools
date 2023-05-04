<?php

namespace Deployer;

# rollback
task('after_rollback', [
    'deploy:cache:clear',
]);
after('rollback', 'after_rollback');
