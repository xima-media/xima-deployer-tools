<?php

namespace Deployer;


set('web_path', 'public/');

set('default_timeout', 900);

set('keep_releases', 2);

set('shared_dirs', [
        'var/log'
    ]
);

set('shared_files', [
        '.env.local'
    ]
);

set('writable_dirs', [
    'var'
]);

set('bin/console', function () {
    return parse('{{release_path}}/bin/console');
});

set('console_options', function () {
    return '--no-interaction';
});

set('composer_options', function () {
    return '--verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader --no-scripts';
});

set('clear_paths', [
    '.git',
    '.gitignore',
    '.gitattributes',
]);

// Look on https://github.com/sourcebroker/deployer-extended#buffer-start for docs
set('buffer_config', function () {
    return [
        'index.php' => [
            'entrypoint_filename' => get('web_path') . 'index.php',
        ],
    ];
});

// Look https://github.com/sourcebroker/deployer-extended-media for docs
set('media',
    [
        'filter' => [
            '+ /public/',
            '+ /public/media/',
            '+ /public/media/**',
            '+ /public/upload/',
            '+ /public/upload/**',
            '- *'
        ]
    ]);

set('feature_index_app_type', 'symfony');