<?php

namespace Deployer;

require_once('feature_init.php');
require_once('url_shortener.php');


task('feature:stop', function () {

    $feature = initFeature();
    deleteFeature($feature);

})
    ->select('type=feature-branch-deployment')
    ->desc('Delete a feature branch instance')
;


/**
 * Delete a feature branch including the instance folder and the related database
 *
 * @throws \Deployer\Exception\Exception
 * @throws \Deployer\Exception\RunException
 * @throws \Deployer\Exception\TimeoutException
 */
function deleteFeature($feature = null): void
{
    $feature = $feature ?: input()->getOption('feature');

    if (isUrlShortener()) {
        removeUrlShortenerPath($feature);
    }

    $databaseName = getDatabaseName($feature);
    runDatabaseCommand("DROP DATABASE IF EXISTS `$databaseName`;", false);
    runExtended("rm -rf " . get('deploy_path'));

    info("feature branch <fg=magenta;options=bold>$feature</> deleted");
}
