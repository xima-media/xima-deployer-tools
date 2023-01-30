<?php

namespace Deployer;

task('build:assets', function () {
    runLocally("cd {{app_path}} && npm run build --cache .npm-cache --prefer-offline");
});
