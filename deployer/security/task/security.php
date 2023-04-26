<?php

namespace Deployer;

use Deployer\Exception\GracefulShutdownException;
use Deployer\Exception\RunException;
use Symfony\Component\Console\Helper\Table;

const COMMAND_SYMFONY = 'symfony security:check --format=json --dir={{security_composer_path}}';
const COMMAND_COMPOSER = 'composer audit --format=json --working-dir={{security_composer_path}}';
const SECURITY_CONTEXT_COMPOSER = 'composer';
const SECURITY_CONTEXT_NPM = 'npm';

task('security:composer', function () {
    checkComposerConsoleTools();
    debug('Checking for security vulnerabilities');
    try {
        $output = runLocally('{{security_composer_command}}');
    } catch (RunException $exception) {
        $output = ($exception->getOutput());
    }
    $vulnerabilities = json_decode($output, true);

    if (empty($vulnerabilities)) {
        writeln('<fg=green>[OK]</> No security vulnerabilities found.');
        return;
    }
    $formattedIssues = formatComposerIssues($vulnerabilities);
    writeln('<fg=yellow>[WARN]</> ' . count($formattedIssues) . ' security vulnerabilities found.');
    printIssueTable($formattedIssues);
    checkIssueCache($formattedIssues, SECURITY_CONTEXT_COMPOSER);
    if (input()->getOption('notify')) {
        notifyIssues($formattedIssues);
    }
})
    ->once()
    ->desc('Checking for composer security vulnerabilities');

task('security:npm', function () {
    checkNpmConsoleTools();
    debug('Checking for security vulnerabilities');
    try {
        $output = runLocally('npm audit --json --only=prod --prefix {{security_npm_path}}');
    } catch (RunException $exception) {
        $output = ($exception->getOutput());
    }
    $vulnerabilities = json_decode($output, true);

    if (empty($vulnerabilities)) {
        writeln('<fg=green>[OK]</> No security vulnerabilities found.');
        return;
    }
    $formattedIssues = formatNpmIssues($vulnerabilities);
    writeln('<fg=yellow>[WARN]</> ' . count($formattedIssues) . ' security vulnerabilities found.');
    printIssueTable($formattedIssues);
    checkIssueCache($formattedIssues, SECURITY_CONTEXT_NPM);
    if (input()->getOption('notify')) {
        notifyIssues($formattedIssues, SECURITY_CONTEXT_NPM);
    }
})
    ->once()
    ->desc('Checking for composer security vulnerabilities');


function checkComposerConsoleTools() {
    $composerVersion = runLocally('composer --version');
    // e.g. "Composer version 2.5.5 2023-03-21 11:50:05"
    preg_match('/(\d+\.\d+\.\d+)/', $composerVersion, $matches);
    $version = $matches[1];

    if (version_compare($version, '2.4', '<')) {
        if (commandExistLocally('symfony')) {
            set('security_composer_command', COMMAND_SYMFONY);
        } else {
            throw new GracefulShutdownException('Neither composer >= 2.4 nor symfony console is available locally to check for security issues.');
        }
    } else {
        set('security_composer_command', COMMAND_COMPOSER);
    }
}


function checkNpmConsoleTools() {
    if (!commandExistLocally('npm')) {
        throw new GracefulShutdownException('npm is missing to check for security issues.');
    }
}

function formatComposerIssues(array $issues) {
    $formattedIssues = [];
    if (get('security_composer_command') === COMMAND_SYMFONY) {
        foreach ($issues as $key => $issue) {
            foreach ($issue['advisories'] as $advisory) {
                $formattedIssue = [
                    'cve' => $advisory['cve'],
                    'package' => $key,
                    'version' => $advisory['version'],
                    'title'  => $advisory['title'],
                    'link'  => $advisory['link'],
                ];
                $formattedIssues[$advisory['cve']] = $formattedIssue;
            }
        }
    } else {
        foreach ($issues['advisories'] as $key => $advisories) {
            foreach ($advisories as $advisory) {
                $formattedIssue = [
                    'cve' => $advisory['cve'],
                    'package' => $key,
                    'version' => $advisory['affectedVersions'],
                    'title'  => $advisory['title'],
                    'link'  => $advisory['link'],
                ];
                $formattedIssues[$advisory['cve']] = $formattedIssue;
            }
        }
    }
    return $formattedIssues;
}

function formatNpmIssues(array $issues) {
    $formattedIssues = [];
    foreach ($issues['vulnerabilities'] as $key => $issue) {
        foreach ($issue['via'] as $advisory) {
            if (!is_array($advisory)) continue;
            $formattedIssue = [
                'cve' => basename($advisory['url']),
                'severity' => coloredOutput($advisory['severity'], [
                    'critical' => 'red',
                    'high' => 'red',
                    'moderate' => 'yellow',
                    'low' => 'white',
                ]),
                'package' => $advisory['name'],
                'version' => $advisory['range'],
                'title' => $advisory['title'],
                'link' => $advisory['url'],
            ];
            $formattedIssues[basename($advisory['url'])] = $formattedIssue;
        }
    }
    return $formattedIssues;
}

function printIssueTable(array $issues) {
    $keys = array_keys(reset($issues));
    (new Table(output()))
        ->setHeaderTitle("Security vulnerabilities")
        ->setHeaders($keys)
        ->setRows($issues)
        ->render();
}

function coloredOutput(string $string, array $matches, string $match = null) {
    $match = is_null($match) ? $string : $match;
    foreach ($matches as $value => $color) {
        if ($value === $match) {
            $string = preg_replace("/($match)/i", "<fg=$color>$1</>", $string);
        }
    }
    return $string;
}

function checkIssueCache(array &$issues, string $type) {
    if (!get('security_use_cache')) return;
    $issuesCopy = $issues;
    $cacheFolder = __DIR__ . '/.cache/';
    $cacheFile = "$type.security_check.cache.json";
    $cacheFilePath = $cacheFolder . $cacheFile;
    if (!is_dir($cacheFolder)) mkdir($cacheFolder, 0755, true);
    if (file_exists($cacheFilePath)) {
        $cacheFileContent = file_get_contents($cacheFilePath);
        $cacheFileContent = $cacheFileContent ? json_decode($cacheFileContent, true) : [];
        $cacheFileKeys = array_keys($cacheFileContent);
        foreach ($cacheFileKeys as $cacheFileKey) {
            if (isset($issues[$cacheFileKey])) {
                unset($issues[$cacheFileKey]);
            }
        }
    }
    file_put_contents($cacheFilePath, json_encode($issuesCopy));
}

function notifyIssues(array $issues, string $type = SECURITY_CONTEXT_COMPOSER) {
    if (empty($issues)) return;
    $message = 'Im Projekt <strong>' . get('project') . '</strong> wurden die folgende(n) ' . count($issues) . ' <em>' .  $type . '</em> Sicherheitslücke(n) entdeckt:';
    foreach ($issues as $cve => $issue) {
        $message .= sprintf(
            '<br/><br/><strong style="color:%s">%s</strong> %s<br/><em>%s</em> – <a href="%s">%s</a>',
            get('security_notification_color'),
            $issue['package'],
            $issue['version'],
            $issue['title'],
            $issue['link'],
            $cve,
        );
    }
    sendMessage($message, get('security_notification_color'));
}