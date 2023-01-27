<?php

namespace Deployer;

require_once('url_shortener.php');

task('feature:init', function () {

    if (!input()->hasOption('feature')) {
        return;
    }
    // extend deploy path / public url
    initFeature();
})->desc('Initialize a feature branch');


/**
 * @param $feature
 * @return string
 * @throws \Deployer\Exception\Exception
 * @throws \Deployer\Exception\RunException
 * @throws \Deployer\Exception\TimeoutException
 */
function initFeature($feature = null): string {

    $feature = $feature ?: input()->getOption('feature');
    set('feature', $feature);

    if (isUrlShortener()) {
        initUrlShortener();
    } else {
        set('deploy_path', get('deploy_path') . '/' . $feature);
        set('public_url', get('public_url') . $feature . '/current/' . get('web_path'));
    }
    return $feature;
}