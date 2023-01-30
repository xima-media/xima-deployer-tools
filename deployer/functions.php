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

/**
 * Extend the deployer configuration with available environment variables (starting with "DEPLOYER_CONFIG_"):
 *
 * ENVIRONMENT_VARIABLE => deployer_configuration
 * e.g.
 * DEPLOYER_CONFIG_DATABASE_PASSWORD => database_password
 *
 * @return void
 * @throws \Deployer\Exception\Exception
 */
function prepareDeployerConfiguration(): void {
    $environmentVariables = getenv();
    foreach ($environmentVariables as $key => $value) {
        if (str_starts_with($key, 'DEPLOYER_CONFIG_')) {
            $configName = strtolower(str_replace('DEPLOYER_CONFIG_', '', $key));

            if (has($configName)) {
                debug("attention: overwriting existing deployer configuration '$configName' with environment variable '$key' ");
            }
            set($configName, $value);
        }
    }
}