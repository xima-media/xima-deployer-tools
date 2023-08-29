<?php

namespace Deployer;

require 'recipe/drupal8.php';

set('default_timeout', 900);

set('web_path', 'web/');
set('drupal_site', 'default');
set('drupal_path', '{{release_path}}/web');
set('drupal_site_path', '{{drupal_path}}/sites/{{drupal_site}}');

set('shared_dirs', [
  'web/sites/{{drupal_site}}/files',
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

set('drush', function () {
  return which('drush');
});
