<?php

namespace Deployer;

use Symfony\Component\Console\Output\OutputInterface;
use function Deployer\input;
use function Deployer\output;

/**
 * @param $message
 * @return void
 */
function debug($message): void
{
    if (isVerbose()) {
        writeln("<fg=yellow;options=bold>debug</> " . parse($message));
    }
}

/**
 * @return bool
 */
function isVerbose(): bool
{
    return in_array(output()->getVerbosity(), [OutputInterface::VERBOSITY_VERBOSE, OutputInterface::VERBOSITY_VERY_VERBOSE, OutputInterface::VERBOSITY_DEBUG], true);
}

/**
 * @return void
 */
function checkVerbosity(): void
{
    if (!empty(getenv('DEPLOYER_CONFIG_VERBOSE'))) {
        output()->setVerbosity(OutputInterface::VERBOSITY_VERBOSE);
    }
}
