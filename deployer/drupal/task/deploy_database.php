<?php

namespace Deployer;

use Xima\XimaDeployerTools\Utility\EnvUtility;

desc('Sync database');
task('deploy:database:sync', function () {
  if (!has('feature_setup') || !get('feature_setup') || !has('db_sync_source') || !get('db_sync_source')) {
    info('<info>Skipping sync db</info>');

    return;
  }

  $source = get('db_sync_source');
  runExtended("cd {{drupal_site_path}} && {{drush}} sql:sync @$source @self --create-db -y");
})->select('type=feature-branch-deployment');

desc('Backup database');
task('deploy:database:backup', function () {
  if (has('current_path') && get('current_path')) {
    runExtended("cd {{current_path}}/{{web_path}}sites/{{drupal_site}} && {{drush}} sql-dump --structure-tables-list=cache,cache_*,queue,watchdog --gzip --result-file=auto");

    // remove all backups but the latest 10
    if(test('[ -d "/home/{{remote_user}}/drush-backups/{{prod_db_name}}" ]')) {
      info("<info>↪ Cleaning drush backups in /home/{{remote_user}}/drush-backups...</info>");

      runExtended("cd /home/{{remote_user}}/drush-backups/{{prod_db_name}} && ls -1tr | head -n -10 | xargs -d '\n' rm -rf --");
    }
  }
})->select('prod');

function getDatabasePasswordForDrupal(): string|bool
{
    $vars = EnvUtility::getRemoteEnvVars();
    if (array_key_exists('DB_PASSWORD', $vars)) {
        return $vars['DB_PASSWORD'];
    }

    return false;
}

function getDatabaseNameForDrupal(): string|bool
{
    $vars = EnvUtility::getRemoteEnvVars();
    if (array_key_exists('DB_DATABASE', $vars)) {
        return $vars['DB_DATABASE'];
    }

    return false;
}
