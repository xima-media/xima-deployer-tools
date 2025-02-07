<?php

namespace Deployer;

desc('Run deploy hooks');
task('deploy:hook:deploy', function () {
    runExtended('cd {{drupal_site_path}} && {{drush}} deploy:hook -y');
});
