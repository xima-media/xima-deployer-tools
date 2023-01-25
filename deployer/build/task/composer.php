<?php

namespace Deployer;

task('build:composer', function () {
    runLocally('cd {{app_path}} && composer {{composer_action}} {{composer_options}}');
});
