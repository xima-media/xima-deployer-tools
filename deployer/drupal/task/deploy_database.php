<?php

namespace Deployer;

desc('Update database');
task('deploy:database:update', function () {
  run('cd {{drupal_site_path}} && drush updb -y');
});

desc('Sync database');
task('deploy:database:sync', function () {
  if (input()->hasOption('sync') && input()->getOption('sync')) {
    $source = input()->getOption('sync');
    run("cd {{drupal_site_path}} && drush sql:sync @$source @self --create-db -y");
  } else {
    writeln('<info>Skipping sync db</info>');
  }
});

desc('Backup database');
task('deploy:database:backup', function () {
  if (has('previous_release') && get('previous_release')) {
    run("cd {{previous_release}} && drush sql-dump --structure-tables-list=cache,cache_*,queue,watchdog --gzip --result-file=auto");

    // remove all backups but the latest 10
    if(test('[ -d "/home/{{remote_user}}/drush-backups/{{prod_db_name}}" ]')) {
      writeln("<info>↪ Cleaning drush backups in /home/{{remote_user}}/drush-backups...</info>");

      run("cd /home/{{remote_user}}/drush-backups/{{prod_db_name}} && ls -1tr | head -n -10 | xargs -d '\n' rm -rf --");
    }
  }
})->select('stage=prod');
