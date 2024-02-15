<?php

namespace Deployer;

require 'recipe/typo3.php';

set('default_timeout', 900);
set('keep_releases', 2);

// TYPO3
set('web_path', 'public/');
set('bin/typo3cms', './vendor/bin/typo3cms');

set('shared_dirs', [
    '{{web_path}}fileadmin',
    '{{web_path}}uploads',
    'var/session',
    'var/log',
    'var/lock',
    'var/charset',
    'var/transient',
]);

set('shared_files', [
    '.env'
]);

set('writable_mode', 'chmod');
set('writable_chmod_mode', '2770');
set('writable_recursive', false);
set('writable_dirs',  [
    '{{web_path}}typo3conf',
    '{{web_path}}typo3temp',
    '{{web_path}}uploads',
    '{{web_path}}fileadmin',
    'var/session',
    'var/log',
    'var/lock',
    'var/charset',
    'var/transient',
]);

set('composer_options', '--verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader --no-scripts');

// Look on https://github.com/sourcebroker/deployer-extended#buffer-start for docs
set('buffer_config', function () {
    return [
        'index.php' => [
            'entrypoint_filename' => get('web_path') . 'index.php',
        ],
        'typo3/index.php' => [
            'entrypoint_filename' => get('web_path') . 'typo3/index.php',
        ],
        'typo3/install.php' => [
            'entrypoint_filename' => get('web_path') . 'typo3/install.php',
        ]
    ];
});

/**
 * Rsync settings
 */
set('rsync_default_excludes', [
    '.Build',
    '.git',
    '.gitlab',
    '.ddev',
    '.deployer',
    '.idea',
    '.DS_Store',
    '.gitlab-ci.yml',
    '.npm',
    'package.json',
    'package-lock.json',
    'node_modules/',
    'var/session',
    'var/log',
    'var/lock',
    'var/charset',
    'var/transient',
    'public/fileadmin/',
    'public/typo3temp/',
]);

set('feature_index_app_type', 'typo3');