<?php

namespace Deployer;

desc('Import files');
task('deploy:files:sync', function () {
  if (input()->hasOption('sync') && input()->getOption('sync')) {
    $source = input()->getOption('sync');
    $excludePath = __DIR__ . '/.deployment/rsync/' . input()->getArgument('stage') . '_exclude.txt';
    $excludeParameter = '';

    if (file_exists($excludePath)) {
      $excludeParameter = str_replace("\n", ':', file_get_contents($excludePath));
    }

    // TODO: check if working
    run("cd {{drupal_site_path}} && drush rsync --exclude-paths=:$excludeParameter @$source:%files @self:%files -v -y");
  } else {
    writeln('<info>Skipping sync files</info>');
  }
});
