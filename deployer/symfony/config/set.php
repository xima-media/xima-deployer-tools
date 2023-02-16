<?php

namespace Deployer;


set('web_path', 'public/');

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
