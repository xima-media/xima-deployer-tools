<?php

namespace Deployer;

desc('Create private/logs');
task('deploy:logs_dir:create', function () {
  run("cd {{release_path}} && mkdir -p private/logs && chmod g+w private && find private/logs -type d -user {{user}} -exec chmod g+w '{}' \; && setfacl -d -m g::rw private/logs");
});
