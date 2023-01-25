<?php

namespace Deployer;

tasK('feature:urlshortener', function () {
    if (!isUrlShortener()) return;

    $symlinkDir = get('deploy_path') . "/current/" . get('web_path');

    run("cd " . get('deploy_path_url_shortener') . " && ln -sf $symlinkDir " . get('feature'));
})->desc('Add the feature branch symlink for the shortened url');


/**
 * @return bool
 */
function isUrlShortener(): bool
{
    return (has('feature_url_shortener') && get('feature_url_shortener'));
}

/**
 * @return void
 * @throws \Deployer\Exception\Exception
 * @throws \Deployer\Exception\RunException
 * @throws \Deployer\Exception\TimeoutException
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
