<?php

namespace Deployer;

desc('Update database');
task('deploy:database:update', function () {
  runExtended('cd {{drupal_site_path}} && {{drush}} updb -y');
});

desc('Sync database');
task('deploy:database:sync', function () {
  if (!has('feature_setup') || !get('feature_setup') || !input()->hasOption('sync') || !input()->getOption('sync')) {
    info('<info>Skipping sync db</info>');

    return;
  }

  $source = input()->getOption('sync');
  runExtended("cd {{drupal_site_path}} && {{drush}} sql:sync @$source @self --create-db -y");
})->select('type=feature-branch-deployment');

desc('Backup database');
task('deploy:database:backup', function () {
  if (has('current_path') && get('current_path')) {
    runExtended("cd {{current_path}} && {{drush}} sql-dump --structure-tables-list=cache,cache_*,queue,watchdog --gzip --result-file=auto");

    // remove all backups but the latest 10
    if(test('[ -d "/home/{{remote_user}}/drush-backups/{{prod_db_name}}" ]')) {
      info("<info>↪ Cleaning drush backups in /home/{{remote_user}}/drush-backups...</info>");

      runExtended("cd /home/{{remote_user}}/drush-backups/{{prod_db_name}} && ls -1tr | head -n -10 | xargs -d '\n' rm -rf --");
    }
  }
})->select('prod');
