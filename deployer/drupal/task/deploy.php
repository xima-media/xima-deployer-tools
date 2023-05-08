<?php

namespace Deployer;

task('deploy', [

    // Standard deployer task
    'deploy:info',

    // Standard deployer task
    'deploy:setup',

    // Read more on https://github.com/sourcebroker/deployer-extended#deploy-check-lock
    'deploy:check_lock',
    // Standard deployer task
    'deploy:lock',

    // Standard deployer task
    'deploy:release',

    // backup db before deployment
    'deploy:database:backup',

    // enable maintenance mode
    'deploy:maintenance:enable',

    // Building composer dependencies
    'build:composer',

    // Building assets
    'build:assets',

    // Standard deployer task
    'rsync',

    // Standard deployer task
    'deploy:shared',

    // Drupal: Sync the db (only on stage)
    'deploy:database:sync',

    // Drupal: Sync the files (only on stage)
    'deploy:files:sync',

    // Drupal: fix permisions for drupal folder
    'deploy:permissions:drupal',

    // Drupal: fix permisions for drupal files folder
    'deploy:permissions:drupal_files',

    // Drupal: clear the cache
    'deploy:cache:clear',

    // Drupal: create private/logs
    'deploy:log_dir:create',

    // Drupal: update database
    'deploy:database:update',

    // Drupal: update translations
    'deploy:translations:update',

    // Drupal: import config
    'deploy:configuration:import',

    // Drupal: clear the cache
    'deploy:cache:clear',

    // Standard deployer task
    'deploy:clear_paths',

    // Start buffering http requests. No frontend access possible from now.
    // Read more on https://github.com/sourcebroker/deployer-extended#buffer-start
    'buffer:start',

    // Standard deployer task
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

    // disable maintenance mode
    'deploy:maintenance:disable',

    // Standard deployer task
    'deploy:unlock',

    // Standard deployer task
    'deploy:cleanup',

    // Standard deployer task
    'deploy:success',
])->desc('Deploy Drupal project');;

after('deploy:failed', 'deploy:unlock');
