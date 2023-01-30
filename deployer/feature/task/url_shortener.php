<?php

namespace Deployer;

tasK('feature:urlshortener', function () {
    if (!isUrlShortener()) return;

    $symlinkDir = get('deploy_path') . "/current/" . get('web_path');

    run("cd " . get('deploy_path_url_shortener') . " && ln -sf $symlinkDir " . get('feature'));
})->desc('Add the feature branch symlink for the shortened url');


/**
 * Check if the url shortener function is activated
 *
 * @return bool
 */
function isUrlShortener(): bool
{
    return (has('feature_url_shortener') && get('feature_url_shortener'));
}

/**
 * Initialize the url shortener function and adjust deploy_path & public_url
 * @param null $feature
 * @return void
 * @throws \Deployer\Exception\Exception
 */
function initUrlShortener($feature = null): void
{
    if (!isUrlShortener()) return;

    $feature = $feature ?: input()->getOption('feature');

    set('deploy_path_url_shortener', get('deploy_path'));
    set('deploy_path', get('deploy_path') . '/' . get('feature_url_shortener_path') . $feature);
    set('public_url', get('public_url') . $feature);
}

/**
 * @param $feature
 * @return string
 */
function getUrlShortenerPath($feature): string
{
    return get('deploy_path_url_shortener') . "/$feature";
}

/**
 * Remove the url shortener symlink to the feature branch instance
 *
 * @param $feature
 * @return void
 * @throws \Deployer\Exception\Exception
 * @throws \Deployer\Exception\RunException
 * @throws \Deployer\Exception\TimeoutException
 */
function removeUrlShortenerPath($feature): void
{
    run("rm -f " . getUrlShortenerPath($feature));
}
