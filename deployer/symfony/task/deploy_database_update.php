<?php

namespace Deployer;

task('deploy:database:update', function () {
    switch (get('deploy_database_update_method', 'migrations_migrate')) {
        case 'migrations_migrate':
            runExtended('{{bin/php}} {{bin/console}} doctrine:migrations:migrate {{console_options}} --allow-no-migration');
            break;
        case 'schema_update':
            runExtended('{{bin/php}} {{bin/console}} doctrine:schema:update {{console_options}} --force');
            break;
    }
})->desc('Update symfony database');