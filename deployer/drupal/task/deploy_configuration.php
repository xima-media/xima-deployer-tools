<?php

namespace Deployer;

desc('Import configuration');
task('deploy:configuration:import', function () {
  runExtended('cd {{drupal_site_path}} && drush cim -y');
});
