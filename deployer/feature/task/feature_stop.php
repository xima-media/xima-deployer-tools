<?php

namespace Deployer;

require_once('feature_init.php');
require_once('url_shortener.php');


task('feature:stop', function () {
  if (!input()->hasOption('feature') || !input()->getOption('feature')) {
    info('<info>Skipping because of missing option "feature"</info>');

    return;
  }

  $feature = input()->getOption('feature');

  info(implode(',', get('feature_stop_disallowed_names')));

  if (in_array($feature, get('feature_stop_disallowed_names'))) {
    info('<info>Stopping the following features is not allowed: ' . implode(', ', get('feature_stop_disallowed_names')) . '. Please do that manually if necessary.</info>');

    return;
  }

  $feature = initFeature($feature);
  deleteFeature($feature);
})
  ->select('type=feature-branch-deployment')
  ->desc('Delete a feature branch instance. Typically used as a downstream pipeline.')
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
