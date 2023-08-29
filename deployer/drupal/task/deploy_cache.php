<?php

namespace Deployer;

desc('Clear cache');
task('deploy:cache:clear', function () {
    runExtended('cd {{drupal_site_path}} && {{drush_binary}} cr');
});
