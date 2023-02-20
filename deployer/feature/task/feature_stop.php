<?php

namespace Deployer;

require_once('feature_init.php');
require_once('url_shortener.php');


task('feature:stop', function () {

    if (!input()->getOption('feature')) {
        return;
    }
    $feature = input()->getOption('feature');
    deleteFeature($feature);

})
    ->select('type=feature-branch-deployment')
    ->desc('Delete a feature branch instance')
;


/**
 * Delete a feature branch including the instance folder and the the related database
 *
 * @throws \Deployer\Exception\Exception
 * @throws \Deployer\Exception\RunException
 * @throws \Deployer\Exception\TimeoutException
 */
function deleteFeature($feature = null): void
{
    $feature = $feature ?: input()->getOption('feature');
    $databaseName = getDatabaseName($feature);

    if (isUrlShortener()) {
        initUrlShortener($feature);
        removeUrlShortenerPath($feature);
    } else {
        set('deploy_path', get('deploy_path') . '/' . $feature);
    }


    runDatabaseCommand("DROP DATABASE IF EXISTS `$databaseName`;", false);
    run("rm -rf " . get('deploy_path'));

    info("feature branch <fg=magenta;options=bold>$feature</> deleted");
}
