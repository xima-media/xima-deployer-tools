<?php

namespace Deployer;

use Symfony\Component\Console\Output\OutputInterface;

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

    debug('Extending deployer configuration with environment variables');
    foreach ($environmentVariables as $key => $value) {
        if (str_starts_with($key, 'DEPLOYER_CONFIG_')) {
            $configName = strtolower(str_replace('DEPLOYER_CONFIG_', '', $key));

            if (has($configName)) {
                debug("Attention: overwriting existing deployer configuration '$configName' with environment variable '$key' ");
            }
            set($configName, $value);
        }
    }
}

/**
 * Check if a subcommand is available, e.g. "php bin/console", "ckeditor:install"
 *
 * @param string $command
 * @param string $subcommand
 * @return bool
 * @throws \Deployer\Exception\Exception
 * @throws \Deployer\Exception\RunException
 * @throws \Deployer\Exception\TimeoutException
 */
function commandSupportSubcommand(string $command, string $subcommand): bool
{
    $check = run("( $command list 2>&1 || $command --list) | grep -- $subcommand || true");
    if (empty($check)) {
        return false;
    }
    return str_contains($check, $subcommand);
}