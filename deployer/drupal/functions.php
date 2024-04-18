<?php

namespace Deployer;

function getDebugLogApp(array $logLines): array
{
    $log = [
        array_merge(get('debug_log_default_header'), ['Context', 'Extra'])
    ];
    foreach ($logLines as $key => $logLine) {
        if (preg_match(get('debug_log_regex_pattern'), $logLine, $matches)) {
            $log[] = [
                $key,
                $matches[1],
                $matches[3],
                $matches[4],
                $matches[6],
                $matches[8]
            ];
        }
    }

    return $log;
}
