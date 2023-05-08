<?php

namespace Deployer;

desc('Import files');
task('deploy:files:sync', function () {
  if (!has('feature_setup') || !get('feature_setup')) {
    return;
  }
  
  if (input()->hasOption('sync') && input()->getOption('sync')) {
    $source = input()->getOption('sync');
    $excludes = has('rsync-files-exclude') ? get('rsync-files-exclude') : [];
    $excludeParameter = '';

    if (!empty($excludes)) {
      $excludeParameter = implode(':', $excludes);
    }

    run("cd {{drupal_site_path}} && drush rsync --exclude-paths=:$excludeParameter @$source:%files @self:%files -v -y");
  } else {
    writeln('<info>Skipping sync files</info>');
  }
})->select('type=feature-branch-deployment');
