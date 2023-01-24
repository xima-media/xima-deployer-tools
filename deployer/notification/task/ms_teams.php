<?php

namespace Deployer;


use Deployer\Utility\Httpie;

task('msteams:notify', function () {
    sendMessage(get('msteams_text'), get('msteams_color'));
})->desc('Send ms teams notification');


/**
 * @param $message
 * @param $color
 * @return void
 */
function sendMessage($message, $color): void
{
    if (!empty(getenv('DEPLOYER_CONFIG_NOTIFICATION_MUTE'))) {
        info("skipping notification because of DEPLOYER_CONFIG_NOTIFICATION_MUTE environment variable");
        return;
    }

    Httpie::post(get('msteams_webhook'))->jsonBody([
        "themeColor" => $color,
        'text'       => $message
    ])->send();
}
