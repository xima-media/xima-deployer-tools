<?php

namespace Deployer;

require 'recipe/drupal8.php';

set('default_timeout', 900);
set('keep_releases', 2);

set('app_type', 'drupal');
set('web_path', 'web/');
set('drupal_site', 'default');
set('drupal_path', '{{release_path}}/web');
set('drupal_site_path', '{{drupal_path}}/sites/{{drupal_site}}');
set('debug_log_path', 'private/logs');
set('debug_log_regex_pattern', '/\[(.*)\]\s(.*)\.([^:]*):\s(.*)/');

set('shared_dirs', [
  'web/sites/{{drupal_site}}/files',
  'private',
]);

set('shared_files', [
  'web/sites/{{drupal_site}}/settings.local.php',
  '.env',
  'drush/drush.local.yml'
]);

set('writable_mode', 'chmod');
set('writable_chmod_mode', '0770');
set('writable_chmod_recursive', false);

set('composer_options', '--verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader --no-scripts');

set('run_real_time_output', true);

// Look on https://github.com/sourcebroker/deployer-extended#buffer-start for docs
set('buffer_config', function () {
    return [
        'index.php' => [
            'entrypoint_filename' =>  get('web_path') . 'index.php',
        ],
        'core/index.php' => [
            'entrypoint_filename' =>  get('web_path') . 'core/install.php',
        ]
    ];
});

set('feature_index_app_type', 'drupal');

set('drush', '../../../vendor/bin/drush');

set('dev_tr_db_dump_dir', function () {
    return run('pwd') . '/.deployment/tr-db-dumps';
});
