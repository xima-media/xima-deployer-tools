<?php

namespace Deployer;

task('build:composer', function () {
    runLocally('composer {{composer_action}} -d {{app_path}} {{composer_options}}');
});
