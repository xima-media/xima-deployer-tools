<?php

namespace Deployer;

desc('Copy MAM Files');
task('deploy:files:copy', function () {
  run("cd {{release_path}} && mkdir -p web/sites/default/files/MAM/selection/ && cp web/modules/contrib/mam/mam_selection/files/* web/sites/default/files/MAM/selection/ && find web/sites/default/files/MAM -type d -user {{user}} -exec chmod g+w '{}' \;");
});
