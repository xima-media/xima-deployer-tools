<?php

namespace Deployer;

desc('Enable maintenance mode in previous release (allowed to fail)');
task('deploy:maintenance:enable', function () {
  if (has('previous_release') && get('previous_release')) {
    run("cd {{previous_release}} && drush sset system.maintenance_mode 1 || true", [], null, null, null, null, true);
  }
});

desc('Disable maintenance mode in current release');
task('deploy:maintenance:disable', function () {
  run("cd {{drupal_site_path}} && drush sset system.maintenance_mode 0", [], null, null, null, null, true);
});
