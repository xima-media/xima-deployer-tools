<?php

namespace Deployer;

desc('Update translations');
task('deploy:translations:update', function () {
  runExtended('cd {{drupal_site_path}} && {{drush}} locale:update -y');
});
