<?php

namespace Deployer;


use Deployer\Exception\GracefulShutdownException;
use Deployer\Utility\Httpie;

task('msteams:notify', function () {
    sendMessage(get('msteams_text'), get('msteams_color'));
})->desc('Send ms teams notification');


/**
 * @param $message
 * @param $color
 * @return void
 * @throws \Deployer\Exception\GracefulShutdownException
 */
function sendMessage($message, $color): void
{
    if (!empty(getenv('DEPLOYER_CONFIG_NOTIFICATION_MUTE'))) {
        debug("skipping notification because of DEPLOYER_CONFIG_NOTIFICATION_MUTE environment variable");
        return;
    }

    $msTeamsWebhook = has('msteams_webhook') ? get('msteams_webhook') : getenv('DEPLOYER_CONFIG_NOTIFICATION_MSTEAMS_WEBHOOK');
    if (!$msTeamsWebhook) {
        throw new GracefulShutdownException('Missing MS Teams webhook for notification task. Use "msteams_webhook" deployer configuration or "DEPLOYER_CONFIG_NOTIFICATION_MSTEAMS_WEBHOOK" environment variable to define the necessary webhook url.');
    }

    Httpie::post(get('msteams_webhook'))->jsonBody([
        "themeColor" => $color,
        'text'       => $message
    ])->send();
}
