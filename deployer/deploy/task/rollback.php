<?php

namespace Deployer;

# rollback
task('after_rollback', [
    'typo3cms:cache:flushandwarmup',
//    'warmup_frontend',
]);
after('rollback', 'after_rollback');
