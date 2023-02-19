<?php

namespace Deployer;

task('build:assets', function () {
    runLocally("npm ci --prefix {{app_path}} --cache .npm-cache --prefer-offline");
    runLocally("npm run build --prefix {{app_path}} --cache .npm-cache --prefer-offline");
});
