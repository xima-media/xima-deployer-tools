<?php

namespace Deployer;

require 'recipe/drupal8.php';

set('default_timeout', 900);

set('web_path', 'web/');
set('drupal_site', 'default');
set('drupal_path', '{{release_path}}/web');
set('drupal_site_path', '{{drupal_path}}/sites/{{drupal_site}}');
// TODO: really needed?
set('drupal_themes_path', 'web/themes/custom');

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

set('feature_templates', [
  __DIR__ . '/.deployment/deployer/templates/.env.dist' => '/shared/.env',
  __DIR__ . '/.deployment/deployer/templates/drush.local.yml.dist' => '/shared/drush/drush.local.yml',
  __DIR__ . '/.deployment/deployer/templates/settings.local.php.dist' => '/shared/web/sites/default/settings.local.php',
]);

// disable sync tools because we have drush in drupal context
set('db_sync_tool', null);
set('file_sync_tool', null);

// Look on https://github.com/sourcebroker/deployer-extended#buffer-start for docs
set('buffer_config', function () {
    return [
        'index.php' => [
            'entrypoint_filename' => get('web_path') . 'index.php',
        ],
        'core/index.php' => [
            'entrypoint_filename' => get('web_path') . 'core/index.php',
        ]
    ];
});

set('feature_index_app_type', 'drupal');
