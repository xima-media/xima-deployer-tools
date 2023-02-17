<?php

namespace Deployer;

/**
 * Default extensions for deploy tasks
 */

before('rollback', 'feature:init');
before('deploy:unlock', 'feature:init');
before('feature:sync', 'feature:init');
before('deploy:setup', 'feature:setup');
before('deploy:success', 'feature:notify');
before('deploy:symlink', 'feature:sync');
after('deploy:symlink', 'feature:urlshortener');

if (!has('feature_branch_deployment')) {
    task('feature:init')->disable();
    task('feature:setup')->disable();
    task('feature:sync')->disable();
    task('feature:urlshortener')->disable();
    task('feature:notify')->disable();
}