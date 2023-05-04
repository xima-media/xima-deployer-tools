<?php

namespace Deployer;

use Symfony\Component\Console\Input\InputOption;

option('sync', 's', InputOption::VALUE_REQUIRED, 'Activate the drush db and file sync from from remote by providing the drush sync source host (e.g. "sitename.master").');
