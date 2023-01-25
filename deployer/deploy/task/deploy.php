<?php

namespace Deployer;

task('deploy', [
    'feature:init',
    'deploy:setup',
    'deploy:lock',
    'deploy:release',
    'build:composer',
    'build:assets',
    'rsync',
    'deploy:shared',
    'deploy:writable',
    'typo3cms:setup',
    'typo3cms:database:updateschema',
    'feature:sync',
    'typo3cms:cache:flushandwarmup',
    'deploy:symlink',
    'feature:urlshortener',
    'typo3cms:cache:flushfrontend',
//    'warmup_frontend',
    'deploy:unlock',
    'deploy:cleanup',
    'feature:notify',
    'deploy:success',
]);

after('deploy:failed', 'deploy:unlock');

# rollback
task('after_rollback', [
    'typo3cms:cache:flushandwarmup',
//    'warmup_frontend',
]);
after('rollback', 'after_rollback');
