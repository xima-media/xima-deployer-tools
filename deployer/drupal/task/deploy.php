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

    // Drupal: clear the cache
    'deploy:cache:clear',

    // Standard deployer task
    'deploy:unlock',

    // Standard deployer task
    'deploy:cleanup',

    // Standard deployer task
    'deploy:success',
])->desc('Deploy Drupal project');;

after('deploy:failed', 'deploy:unlock');

// override dev:sync
task('dev:sync', function () {
  $source = get('db_sync_source_local');

  runExtended("drush sql:sync @$source @self --create-db -y");
})
  ->desc('Sync database with drush');

// prepare post_db_sync
task('dev:tabula_rasa:post_db_sync', function() {
  runExtended('drush cache-rebuild');
  runExtended('drush updb -y');
  runExtended('drush cim -y');
  runExtended('drush cache-rebuild');
});

// override dev:tabula_rasa
task('dev:tabula_rasa', [
  'dev:tabula_rasa:composer_install_app',
  'dev:tabula_rasa:composer_install_ci',
  'dev:tabula_rasa:npm_build',
  'dev:tabula_rasa:db_sync',
  'dev:tabula_rasa:post_db_sync',
]);
