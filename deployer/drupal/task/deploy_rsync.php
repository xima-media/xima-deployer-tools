<?php

namespace Deployer;

// TODO: already contained in deployer tools?
desc('Rsync code to target');
task('deploy:upload', function () {
  $excludePath = get('deployer_path') . '/rsync-exclude.txt';
  writeln('<info>↪ Rsync {{app_dir}} => {{deploy_path}}</info>');
  runLocally('rsync --delete --recursive --no-perms --no-owner --no-group --links --exclude-from=$excludePath --force {{app_dir}}/. {{user}}@{{hostname}}:{{deploy_path}}');
});
