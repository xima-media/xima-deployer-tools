<?php

namespace Deployer;

require_once('feature_init.php');

task('feature:index', function () {
    if (!has('feature_branch_deployment')) return;

    checkVerbosity();

    $path = get('deploy_path') . '/index.php';
    $upload = true;
    if (test("[[ -f $path ]]")) {
        $upload = askConfirmation("A index.php file already exists: " . $path . " \n Do you really want to override the file?", true);
    }
    if ($upload) {
        renderIndexTemplate();
    }
})->desc('Provide an index.php file for a simple feature branch overview on the remote system');


/**
 * Render the remote index.php file as feature instance overview
 *
 * @throws \Deployer\Exception\RunException
 * @throws \Deployer\Exception\Exception
 * @throws \Deployer\Exception\TimeoutException
 */
function renderIndexTemplate(): void
{
    $arguments = [
        'DEPLOYER_CONFIG_FEATURE_INDEX_TITLE' => get('feature_index_title'),
        'DEPLOYER_CONFIG_FEATURE_INDEX_APP_PATH' => get('feature_index_app_path'),
        'DEPLOYER_CONFIG_FEATURE_INDEX_APP_TYPE' => get('feature_index_app_type'),
    ];

    debug('Preparing index template');

    // Add additional links
    if (has('feature_index_additional_links')) {
        $preparedLink = [];
        foreach (get('feature_index_additional_links') as $title => $link) {
            $preparedLink[] = "$title|$link";
        }
        $arguments['DEPLOYER_CONFIG_FEATURE_INDEX_ADDITIONAL_LINKS'] = implode(",", $preparedLink);
    }

    uploadTemplate(__DIR__ . '/../dist/index.php.dist', '/index.php', $arguments);

}
