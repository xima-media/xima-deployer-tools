<?php

namespace Deployer;

task('build:assets', function () {
    runLocally("cd {{app_path}} && npm build --cache .npm-cache --prefer-offline");
});
