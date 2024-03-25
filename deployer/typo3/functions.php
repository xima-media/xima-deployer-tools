<?php

namespace Deployer;

function getDebugLogApp(array $logLines): array
{
    $log = [
        ['#', 'Date', 'Level', 'Message']
    ];
    foreach ($logLines as $key => $logLine) {
        if (preg_match(get('debug_log_regex_pattern'), $logLine, $matches)) {
            $log[] = [
                $key,
                $matches[1],
                $matches[2],
                $matches[4]
            ];
        }
    }
    return $log;
}