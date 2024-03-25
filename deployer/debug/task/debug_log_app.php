<?php

namespace Deployer;

use Deployer\Exception\Exception;
use Symfony\Component\Console\Helper\Table;

task('debug:log:app', function () {
    $activePath = get('deploy_path') . '/' . (test('[ -L {{deploy_path}}/release ]') ? 'release' : 'current');
    $logPath = get('debug_log_path');

    if (!$logPath) {
        throw new Exception('Missing "debug_log_path" configuration');
    }

    $logFile = askChoice("Please select a log file to debug in $logPath", array_map(function ($array) {
        return $array[1];
    }, listFiles("$activePath/$logPath")), 0);

    $logFilePath = "$activePath/$logPath/$logFile";
    $logRaw = runExtended("tail $logFilePath", real_time_output: false);

    $logLines = explode("\n", $logRaw);


    $type = ucfirst(get('app_type'));
    switch ($type) {
        case 'typo3':
            require_once(__DIR__ . '/../../typo3/functions.php');
            break;
        case 'drupal':
            require_once(__DIR__ . '/../../drupal/functions.php');
            break;
        case 'symfony':
            require_once(__DIR__ . '/../../symfony/functions.php');
            break;
    }

    $log = getDebugLogApp($logLines);
    $logHeader = array_shift($log);
    $previewLog = [];

    foreach ($log as $logLine) {
        $previewLog[] = [
            $logLine[0],
            (new \DateTime($logLine[1]))->format(get('debug_log_date_format')),
            colorizeLevel($logLine[2]),
            wordwrap(substr($logLine[3], 0, get('debug_log_preview_length')) . '...', 150, "\n", true)
        ];
    }

    /*
     * Preview
     */
    (new Table(output()))
        ->setHeaderTitle(currentHost()->getAlias())
        ->setHeaders($logHeader)
        ->setRows($previewLog)
        ->render();

    /*
     * Detail
     */
    ask('Do you want to inspect one of the log entries?', true);
    $logEntry = askChoice('Please select a log file entry to inspect', array_map(function ($ar) {
        return "(" . $ar[0] . ") " . $ar[1] . " [" . $ar[2] . "]";
    }, $log), count($log) - 1);
    if (preg_match('/\((.*?)\)/', $logEntry, $matches)) {
        displayEntry($logHeader, $log[$matches[1]]);
    }
})
    ->desc('Inspect the last app log entries');


function displayEntry(array $labels, array $entry): void
{
    $table = [];
    foreach ($entry as $key => $item) {
        $table[] = [$labels[$key], $item];
    }
    $table[1] = [$labels[1], (new \DateTime($entry[1]))->format(get('debug_log_date_format')),];
    $table[2] = [$labels[2], colorizeLevel($entry[2])];
    $table[3] = [$labels[3], wordwrap($entry[3], 150, "\n", true)];

    (new Table(output()))
        ->setHeaderTitle(currentHost()->getAlias())
        ->setRows($table)
        ->render();
}

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
