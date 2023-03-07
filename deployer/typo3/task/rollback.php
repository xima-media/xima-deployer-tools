<?php

namespace Deployer;

# rollback
task('after_rollback', [
    // custom flush and warmup system specific caches
    'deploy:cache:flush_and_warmup',
]);
after('rollback', 'after_rollback');
