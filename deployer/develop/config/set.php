<?php

namespace Deployer;

set('develop_default_branch', 'main');
set('composer_path_app', '.');
set('composer_path_ci', '.');
set('develop_git_message_new_version', 'build: version');
set('develop_git_message_composer_update_app', 'chore(app): composer update');
set('develop_git_message_composer_update_ci', 'chore(ci): composer update');
set('develop_git_message_npm_update', 'chore(app): npm update');
set('develop_semver_regex', '/^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)(?:-([0-9A-Za-z-]+(?:\.[0-9A-Za-z-]+)*))?(?:\+([0-9A-Za-z-]+(?:\.[0-9A-Za-z-]+)*))?$/');
set('develop_composer_regex', '/- Upgrading ([\w\/-]+) \((v?\d+\.\d+\.\d+ => v?\d+\.\d+\.\d+)\)/');


set('develop_composer_update_app', true);
set('develop_composer_update_ci', false);
set('develop_npm_update', false);
set('develop_npm_build', false);
set('develop_acceptance_test', false);
set('develop_php_qs', false);
set('develop_npm_qs', false);

localhost('local');