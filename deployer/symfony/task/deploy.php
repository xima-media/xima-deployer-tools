<?php

namespace Deployer;

// Reuse https://github.com/sourcebroker/deployer-extended-symfony5/blob/main/deployer/deploy/task/deploy.php
task('deploy', [

    // Standard deployer task.
    'deploy:info',

    // Read more on https://github.com/sourcebroker/deployer-extended#deploy-check-lock
    'deploy:check_lock',

    // Standard deployer task.
    'deploy:prepare',

    // Standard deployer task.
    'deploy:lock',

    // Standard deployer task.
    'deploy:release',

    //
    'rsync',

    // Standard deployer task.
    'deploy:shared',

    // Standard deployer task.
    'deploy:writable',

    // Standard deployer task.
    'deploy:clear_paths',

    // Special for symfony5
    'deploy:database:update',

    // Special for symfony5
    'deploy:cache:clear',

    // Special for symfony5
    'deploy:cache:warmup',

    // Create database backup, compress and copy to database store.
    // Read more on https://github.com/sourcebroker/deployer-extended-database#db-backup
//    'db:backup',

    // Start buffering http requests. No frontend access possible from now.
    // Read more on https://github.com/sourcebroker/deployer-extended#buffer-start
    'buffer:start',

    // Truncate caching tables, all cf_* tables
    // Read more on https://github.com/sourcebroker/deployer-extended-database#db-truncate
//    'db:truncate',

    // Standard deployer task.
    'deploy:symlink',

    // Clear php cli cache.
    // Read more on https://github.com/sourcebroker/deployer-extended#cache-clear-php-cli
    'cache:clear_php_cli',

    // Clear frontend http cache.
    // Read more on https://github.com/sourcebroker/deployer-extended#cache-clear-php-http
    'cache:clear_php_http',

    // Frontend access possible again from now
    // Read more on https://github.com/sourcebroker/deployer-extended#buffer-stop
    'buffer:stop',

    // Standard deployer task.
    'deploy:unlock',

    // Standard deployer task.
    'deploy:cleanup',

    // Standard deployer task.
    'deploy:success',

])->desc('Deploy your Symfony5 project');

after('deploy:failed', 'deploy:unlock');