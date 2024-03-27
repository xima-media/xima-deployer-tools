<?php

namespace Deployer;

# general
set('develop_default_branch', 'main');
set('composer_path_app', '.');
set('composer_path_ci', '.');
set('npm_path_app', '.');
set('develop_git_message_new_version', 'build: version');
set('develop_git_message_composer_update_app', 'chore(app): composer update');
set('develop_git_message_composer_update_ci', 'chore(ci): composer update');
set('develop_git_message_npm_update', 'chore(app): npm update');
set('develop_semver_regex', '/^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)(?:-([0-9A-Za-z-]+(?:\.[0-9A-Za-z-]+)*))?(?:\+([0-9A-Za-z-]+(?:\.[0-9A-Za-z-]+)*))?$/');
set('develop_composer_regex', '/- Upgrading ([\w\/-]+) \((v?\d+\.\d+\.\d+ => v?\d+\.\d+\.\d+)\)/');

# callbacks
set('develop_php_qs_callback', function () {
    runLocally("composer check --working-dir " . get('composer_path_app'));
});
set('develop_npm_qs_callback', function () {
    runLocally("npm run lint ---prefix " . get('npm_path_app'));
});
# set('develop_release_callback', function() {});

# available steps
# - composer_update_app
# - composer_update_ci
# - php_qs
# - npm_update
# - npm_qs
# - acceptance_test
#
set('develop_release_steps', [
    'composer_update_app',
    'php_qs'
]);

localhost('local');