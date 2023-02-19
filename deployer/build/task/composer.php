<?php

namespace Deployer;

task('build:composer', function () {
    runLocally('{{bin/composer}} {{composer_action}} -d {{app_path}} {{composer_options}}');
});
