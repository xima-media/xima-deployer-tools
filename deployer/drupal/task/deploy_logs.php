<?php

namespace Deployer;

desc('Create private/logs');
task('deploy:log_dir:create', function () {
  runExtended("cd {{release_path}} && mkdir -p private/logs && chmod g+w private && find private/logs -type d -user {{remote_user}} -exec chmod g+w '{}' \; && setfacl -d -m g::rw private/logs");
});
