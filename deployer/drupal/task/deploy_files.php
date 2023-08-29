<?php

namespace Deployer;

desc('Import files');
task('deploy:files:sync', function () {
  if (!has('feature_setup') || !get('feature_setup') || !input()->hasOption('sync') || !input()->getOption('sync')) {
    info('<info>Skipping sync files</info>');

    return;
  }
  
  $source = input()->getOption('sync');
  $excludes = has('rsync-files-exclude') ? get('rsync-files-exclude') : [];
  $excludeParameter = '';

  if (!empty($excludes)) {
    $excludeParameter = implode(':', $excludes);
  }

  runExtended("cd {{drupal_site_path}} && {{drush}} rsync --exclude-paths=:$excludeParameter @$source:%files @self:%files -v -y");
})->select('type=feature-branch-deployment');
