<?php

namespace Deployer;

desc('Clear cache');
task('deploy:drush:cache:rebuild', function () {
  runExtended('cd {{drupal_site_path}} && {{drush}} cr');
});

desc('Drush deploy');
task('deploy:drush:deploy', function () {
  runExtended('cd {{drupal_site_path}} && {{drush}} deploy -y');
});

desc('Update translations');
task('deploy:drush:translations:update', function () {
  runExtended('cd {{drupal_site_path}} && {{drush}} locale:check -y && {{drush}} locale:update -y');
});

desc('Enable maintenance mode in previous release (allowed to fail)');
task('deploy:drush:maintenance:enable', function () {
  if (has('previous_release') && get('previous_release')) {
    runExtended("cd {{previous_release}} && {{drush}} sset system.maintenance_mode 1 || true");
  }
});

desc('Disable maintenance mode in current release');
task('deploy:drush:maintenance:disable', function () {
  runExtended("cd {{drupal_site_path}} && {{drush}} sset system.maintenance_mode 0");
});