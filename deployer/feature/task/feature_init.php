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
function initFeature($feature = null): string
{
    // check if feature was already initialized
    if (has('feature_initialized') && get('feature_initialized')) return get('feature');;

    $feature = $feature ?: input()->getOption('feature');
    set('feature', $feature);

    if (isUrlShortener()) {
        initUrlShortener();
    } else {
        // extend deploy path with feature directory
        set('deploy_path', get('deploy_path') . '/' . $feature);
        // extend public url path with feature path and specific web path
        set('public_url', get('public_url') . $feature . '/current/' . get('web_path'));

    }
    set('feature_initialized', true);
    return $feature;
}