<?php

namespace Deployer;

use Deployer\Exception\Exception;
use Symfony\Component\Console\Helper\Table;

task('debug:log:app', function () {
    $activePath = get('deploy_path') . '/' . (test('[ -L {{deploy_path}}/release ]') ? 'release' : 'current');
    $logPath = get('log_path');

    if (!$logPath) {
        throw new Exception('Missing "log_path" configuration');
    }

    $logFile = askChoice("Please select a log file to debug in $logPath", array_map(function ($array) {
        return $array[1];
    }, listFiles("$activePath/$logPath")), 0);

    $logFilePath = "$activePath/$logPath/$logFile";
    $logRaw = runExtended("tail $logFilePath", real_time_output: false);

    $logLines = explode("\n", $logRaw);

    $log = [];
    foreach ($logLines as $key => $logLine) {
        if (preg_match(get('debug_log_regex_pattern'), $logLine, $matches)) {
            $log[] = [
                $key,
                (new \DateTime($matches[1]))->format(get('debug_log_date_format')),
                colorizeLevel($matches[2]),
                wordwrap(substr($matches[4], 0, get('debug_log_preview_length')) . '...', 150, "\n", true)
            ];
        }
    }

    (new Table(output()))
        ->setHeaderTitle(currentHost()->getAlias())
        ->setHeaders(['Entry', 'Date', 'Level', 'Message'])
        ->setRows($log)
        ->render();

    ask('Do you want to inspect one of the log entries?', true);
    $logEntry = askChoice('Please select a log file entry to inspect', array_map(function ($ar) {
        return "(" . $ar[0] . ") " . $ar[1] . " [" . $ar[2] . "]";
    }, $log), count($log) - 1);
    if (preg_match('/\((.*?)\)/', $logEntry, $matches)) {
        output()->writeln('<fg=blue>Log entry</>');
        output()->writeln($logLines[$matches[1]]);
    }
})
    ->desc('Get the ssh command to open the shell for a feature branch');


function listFiles(string $path): array
{
    $directoryStats = runExtended("cd $path && stat -c '%Y %n ' *", real_time_output: false);
    $directoryStats = explode("\n", $directoryStats);
    return array_map(static function ($item) {
        return explode(" ", $item);
    }, $directoryStats);
}

function colorizeLevel(string $level): string
{
    switch (strtolower($level)) {
        case 'critical':
        case 'fatal':
        case 'error':
        case 'alert':
        case 'exception':
            return "<fg=red>$level</>";
        case 'warning':
            return "<fg=yellow>$level</>";
        case 'info':
            return "<fg=blue>$level</>";
        case 'debug':
        case 'trace':
            return "<fg=gray>$level</>";
        default:
            return $level;
    }
}
