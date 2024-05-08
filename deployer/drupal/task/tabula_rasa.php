<?php

namespace Deployer;

task('dev:tabula_rasa:post_db_sync', function() {
  runExtended('drush cache-rebuild');
  runExtended('drush updb -y');
  runExtended('drush cim -y');
  runExtended('drush cache-rebuild');
});

// override dev command
task('dev:tr', [
  'dev:tabula_rasa:composer_install_app',
  'dev:tabula_rasa:composer_install_ci',
//  'dev:tabula_rasa:npm_build',
//  'dev:tabula_rasa:db_sync',
  'dev:tabula_rasa:post_db_sync',
]);
