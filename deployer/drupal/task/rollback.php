<?php

namespace Deployer;

# rollback
task('after_rollback', [
    'deploy:drush:cache:rebuild',
]);
after('rollback', 'after_rollback');
