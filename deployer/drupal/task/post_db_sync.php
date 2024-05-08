<?php

namespace Deployer;

task('dev:tabula_rasa:post_db_sync', function() {
  runExtended('drush cache-rebuild');
  runExtended('drush updb -y');
  runExtended('drush cim -y');
  runExtended('drush cache-rebuild');
});

after('dev:sync', 'dev:tabula_rasa:post_db_sync');
