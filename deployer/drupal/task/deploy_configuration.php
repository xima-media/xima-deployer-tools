<?php

namespace Deployer;

desc('Import configuration');
task('deploy:configuration:import', function () {
  run('cd {{drupal_site_path}} && drush cim -y', [], null, null, null, null, true);
});
