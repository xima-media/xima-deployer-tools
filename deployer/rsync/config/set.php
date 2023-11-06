<?php

namespace Deployer;

require 'contrib/rsync.php';

set('repository', '');
set('default_timeout', 900);

set('rsync-exclude-file', '.deployment/rsync/exclude.txt');

/**
 * rsync
 */
set('rsync_src', './{{app_path}}');
set('rsync', [
    'exclude' => [],
    'exclude-file' => get('rsync-exclude-file'),
    'include' => [],
    'include-file' => false,
    'filter' => [],
    'filter-file' => false,
    'filter-perdir' => false,
    'flags' => 'rzltp',
    'options' => ['delete'],
    'timeout' => 600,
]);
