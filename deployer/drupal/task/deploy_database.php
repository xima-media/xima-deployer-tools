<?php

namespace Deployer;

desc('Update database');
task('deploy:database:update', function () {
  run('cd {{drupal_site_path}} && drush updb -y', [], null, null, null, null, true);
});

desc('Sync database');
task('deploy:database:sync', function () {
  if (!has('feature_setup') || !get('feature_setup') || !input()->hasOption('sync') || !input()->getOption('sync')) {
    info('<info>Skipping sync db</info>');

    return;
  }

  $source = input()->getOption('sync');
  run("cd {{drupal_site_path}} && drush sql:sync @$source @self --create-db -y", [], null, null, null, null, true);
})->select('type=feature-branch-deployment');

desc('Backup database');
task('deploy:database:backup', function () {
  if (has('previous_release') && get('previous_release')) {
    run("cd {{previous_release}} && drush sql-dump --structure-tables-list=cache,cache_*,queue,watchdog --gzip --result-file=auto", [], null, null, null, null, true);

    // remove all backups but the latest 10
    if(test('[ -d "/home/{{remote_user}}/drush-backups/{{prod_db_name}}" ]')) {
      info("<info>↪ Cleaning drush backups in /home/{{remote_user}}/drush-backups...</info>");

      run("cd /home/{{remote_user}}/drush-backups/{{prod_db_name}} && ls -1tr | head -n -10 | xargs -d '\n' rm -rf --", [], null, null, null, null, true);
    }
  }
})->select('prod');
