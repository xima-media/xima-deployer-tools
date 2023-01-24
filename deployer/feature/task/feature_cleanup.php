<?php

namespace Deployer;

use Symfony\Component\Console\Helper\Table;
require_once('feature_init.php');
require_once('feature_list.php');
require_once('feature_stop.php');

task('feature:cleanup', function () {

    runLocally('git pull');
    $gitBranches = runLocally('git branch -r | tr "\\n" "," | tr -d \' \' | sed \'s/origin\\///g\' | sed \'s/.$//\'');
    $gitBranches = explode(',', $gitBranches);
    $remoteInstances = listFeatureInstances();
    $remoteInstances = array_map(static function($item){ return $item[2];}, $remoteInstances);

    $comparison = [];
    foreach ($gitBranches as $branch) {
        $featureName = getFeatureName($branch);
        if (in_array($featureName, $remoteInstances, true)) {
            // feature instance is in sync
            $comparison[] = [
                "<fg=green>$featureName</>",
                "<fg=green>$featureName</>"
            ];
            unset($remoteInstances[array_search($featureName, $remoteInstances, true)]);
        } else {
            // git branch has no feature instance
            $comparison[] = [
                "<fg=yellow>$featureName</>",
                ""
            ];
        }
    }
    foreach ($remoteInstances as $instance) {
        // git branch is gone, feature instance should be deleted
        $comparison[] = [
            "",
            "<fg=red>$instance</>"
        ];
    }
    (new Table(output()))
        ->setHeaderTitle(currentHost()->getAlias())
        ->setHeaders(["Remote Git Branch", 'Remote Feature Instance'])
        ->setRows($comparison)
        ->render();


    $delete = askConfirmation("Do you want to cleanup all remote feature instances which haven't an according git branch anymore? (marked as <fg=red>red</>)", false);

    if ($delete) {
        foreach ($remoteInstances as $instance) {
            deleteFeature($instance);
        }
    }

})->desc('Compare remote git branches with remote feature instances and provides a cleanup for all untracked feature instances on the remote server');
