<?php

namespace Deployer;

task('dev:post_db_sync', function() {
  runExtended('drush cache-rebuild');
  runExtended('drush updb -y');
  runExtended('drush cim -y');
  runExtended('drush cache-rebuild');
});

after('dev:sync', 'dev:post_db_sync');
