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