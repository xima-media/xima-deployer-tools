<?php

namespace Deployer;


/**
 * Feature Deployment
 */
set('mysql', 'mysql');

set('feature_templates', []);
set('project', 'kickstarter');

set('database_host', '127.0.0.1');
set('database_port', 3306);

set('web_path', 'public/');

#set('database_collation', null);
#set('database_charset', null);

/**
 * Feature Sync
 */
#set('feature_sync_config', null);
#set('feature_sync_target_path', null);
set('db_sync_tool', 'db_sync_tool');

/**
 * Feature Notification
 */
set('feature_msteams_color', '#0097A7');
set('feature_msteams_text', 'Der Branch **[{{feature}}]({{public_url}})** wurde bereitgestellt.');


/**
 * Feature Url Shortener
 */
#set('feature_url_shortener', null);
set('feature_url_shortener_path', '.dep/instances/');

/**
 * Feature Index
 */
set('feature_index_title', 'DEMO');
set('feature_index_app_path', '');
