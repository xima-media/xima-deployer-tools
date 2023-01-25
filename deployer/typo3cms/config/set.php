<?php

namespace Deployer;

require 'recipe/typo3.php';

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
    '{{web_path}}/.htaccess',
    '.env'
]);

set('writable_mode', 'chmod');
set('writable_chmod_mode', '0775');
set('writable_dirs',  [
    '{{web_path}}typo3conf',
    '{{web_path}}typo3temp',
    '{{web_path}}uploads',
    '{{web_path}}fileadmin'
]);
