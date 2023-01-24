<?php

namespace Deployer;

require_once(__DIR__ . '/../../notification/task/ms_teams.php');


task('feature:notify', function () {

    if (has('initial_deployment') && !get('initial_deployment')) return;

    sendMessage(get('feature_msteams_text'), get('feature_msteams_color'));

})->desc('Notify about successful feature branch deployment');
