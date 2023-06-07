<?php

namespace Deployer;

desc('Enable maintenance mode in previous release (allowed to fail)');
task('deploy:maintenance:enable', function () {
  if (has('previous_release') && get('previous_release')) {
    runExtended("cd {{previous_release}} && drush sset system.maintenance_mode 1 || true");
  }
});

desc('Disable maintenance mode in current release');
task('deploy:maintenance:disable', function () {
  runExtended("cd {{drupal_site_path}} && drush sset system.maintenance_mode 0");
});
