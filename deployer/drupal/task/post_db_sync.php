<?php

namespace Deployer;

task('dev:post_db_sync', function() {
  runExtended('drush deploy');
});

after('dev:sync', 'dev:post_db_sync');
after('dev:tr', 'dev:post_db_sync');
after('dev:release:tabula_rasa', 'dev:post_db_sync');
