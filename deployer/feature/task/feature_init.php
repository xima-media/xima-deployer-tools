<?php

namespace Deployer;

require_once('url_shortener.php');
require_once(__DIR__ . '/../../functions.php');

task('feature:init', function () {

    if (!input()->hasOption('feature')) {
        return;
    }
    checkVerbosity();
    // extend deploy path / public url
    initFeature();
})->desc('Initialize a feature branch')->once();


/**
 * Initialize a feature branch
 * (!: needed for all deployer tasks considering a feature branch)
 *
 * @param $feature
 * @return string|null
 * @throws \Deployer\Exception\Exception
 * @throws \Deployer\Exception\RunException
 * @throws \Deployer\Exception\TimeoutException
 * @throws \Exception
 */
function initFeature($feature = null): ?string
{
    if (!verifyFeatureTasks()) return null;

    debug('Initializing feature instance');
    // check if feature was already initialized
    if (has('feature_initialized') && get('feature_initialized')) return get('feature');;

    prepareDeployerConfiguration();

    $feature = $feature ?: input()->getOption('feature');
    set('feature', $feature);

    if (isUrlShortener()) {
        // initialize the url shortener function
        initUrlShortener();
        set('npm_variables','FEATURE_BRANCH_PATH_PUBLIC=/' . $feature . ' ');
    } else {
        // extend deploy path with feature directory
        set('deploy_path', get('deploy_path') . '/' . $feature);

        // extend public url path with feature path and specific web path
        $publicUrls = [];
        foreach (get('public_urls') as $publicUrl) {
            $publicUrls[] = $publicUrl . $feature . '/current/' . get('web_path');
        }
        set('public_urls', $publicUrls);
        set('npm_variables', 'FEATURE_BRANCH_PATH_PUBLIC=/' . $feature . '/current/' . get('web_path') . ' ');
    }
    set('feature_initialized', true);
    return $feature;
}