<?php

namespace Deployer;

desc('Clear cache');
task('deploy:cache:clear', function () {
    run('cd {{drupal_site_path}} && drush cr', [], null, null, null, null, true);
});
