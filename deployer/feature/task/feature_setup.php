<?php

namespace Deployer;

require_once ('feature_init.php');
require_once('url_shortener.php');

task('feature:setup', function () {

    if (!input()->hasOption('feature')) {
        return;
    }

    // extend deploy path / public url
    $feature = initFeature();

    if (!checkFeatureBranchExists()) {
        info("initializing feature branch <fg=magenta;options=bold>$feature</>");
        set('initial_deployment', true);
        createDatabase();
        renderRemoteTemplates();
    } else {
        set('initial_deployment', false);
    }
})->desc('Setup a feature branch');

/**
 * Create a new database for the feature branch
 *
 * @return void
 * @throws \Deployer\Exception\Exception
 * @throws \Deployer\Exception\RunException
 * @throws \Deployer\Exception\TimeoutException
 */
function createDatabase(): void
{
    $databaseName = getDatabaseName();
    $additionalParams = '';

    if (has('database_collation')) {
        $additionalParams .= ' COLLATE ' . get('database_collation');
    }

    if (has('database_charset')) {
        $additionalParams .= ' CHARACTER SET ' . get('database_charset');
    }

    runDatabaseCommand("CREATE DATABASE IF NOT EXISTS `$databaseName`{$additionalParams};", false);
}

/**
 * Run a database command on the remote system
 *
 * @throws \Deployer\Exception\RunException
 * @throws \Deployer\Exception\TimeoutException
 * @throws \Deployer\Exception\Exception
 */
function runDatabaseCommand($command, $useDoubleQuotes = true): string
{
    $databaseUser = get('database_user');
    $databaseHost = get('database_host');
    $databasePort = get('database_port');
    $databasePassword = has('database_password') ? get('database_password') : getenv('DEPLOYER_CONFIG_DATABASE_PASSWORD');

    if (!$databasePassword) {
        $databasePassword = askHiddenResponse("Enter the database password for $databaseUser@$databaseHost:");
    }
    $quote = $useDoubleQuotes ? '"' : '\'';

    return run(get('mysql') . " -u$databaseUser -p%secret% -h$databaseHost -P$databasePort -e {$quote}$command{$quote}", [],null,null, $databasePassword);
}

/**
 * Checks if a feature branch already exists regarding the database and the server path
 *
 * @throws \Deployer\Exception\Exception
 * @throws \Deployer\Exception\RunException
 * @throws \Deployer\Exception\TimeoutException
 */
function checkFeatureBranchExists(): bool
{
    $path = get('deploy_path');
    $databaseName = getDatabaseName();
    return (str_replace(' ', '', runDatabaseCommand("SHOW DATABASES LIKE '$databaseName'")) !== '' &&
        test("[[ -d $path ]]"));
}

/**
 * Render additional remote files by given templates to ensure the operability of feature branches
 *
 * Configure the registration of templates like this:
 *
 * set('feature_templates', [
 *    __DIR__ . '/.deployment/deployer/templates/.env.dist' => '/shared/.env'
 * ]);
 *
 * Within the template file (e.g. .env.dist) are arguments to replace available:
 *  {{DEPLOYER_CONFIG_DATABASE_USER}}
 *
 * @return void
 * @throws \Deployer\Exception\Exception
 * @throws \Deployer\Exception\RunException
 * @throws \Deployer\Exception\TimeoutException
 */
function renderRemoteTemplates(): void
{
    $databaseName = getDatabaseName();
    $feature = input()->getOption('feature');
    $templates = get('feature_templates');

    // ToDo: simplify!
    // get additional arguments from environment variables
    $environmentVariables = getenv();
    $additionalTemplateVariables = [];
    foreach ($environmentVariables as $key => $value) {
        if (str_starts_with($key, 'DEPLOYER_CONFIG_')) {
            $additionalTemplateVariables[$key] = $value;
        }
    }

    // preparing default arguments for templates and extend by additional template variables
    $arguments = array_merge([
        'DEPLOYER_CONFIG_DATABASE_HOST' => get('database_host'),
        'DEPLOYER_CONFIG_DATABASE_PORT' => get('database_port'),
        'DEPLOYER_CONFIG_DATABASE_USER' => get('database_user'),
        'DEPLOYER_CONFIG_DATABASE_NAME' => $databaseName,
        'DEPLOYER_CONFIG_FEATURE_NAME' => (string)$feature,
        'DEPLOYER_CONFIG_FEATURE_URL' => get('public_url'),
        'DEPLOYER_CONFIG_FEATURE_PATH' => $feature . '/current/' . get('web_path'),
    ],
        $additionalTemplateVariables)
    ;

    // iterate through predefined templates
    foreach ($templates as $template => $target) {
        uploadTemplate($template, $target, $arguments);
    }
}

/**
 * Extend a given local template with the provided arguments and uploads them to a remote host
 *
 * @param $localTemplate
 * @param $remoteTarget
 * @param $arguments
 * @return void
 * @throws \Deployer\Exception\Exception
 * @throws \Deployer\Exception\RunException
 * @throws \Deployer\Exception\TimeoutException
 */
function uploadTemplate($localTemplate, $remoteTarget, $arguments): void {
    $templateContent = file_get_contents($localTemplate);

    // replace all {{variables}} with arguments
    foreach ($arguments as $argument => $replacement) {
        $templateContent = str_replace('{{' .$argument . '}}', (string)$replacement, $templateContent);
    }

    // generate temporary local file for file upload to remote
    $temporaryFileName = ".deployer." . preg_replace('/[^A-Za-z0-9\-]/', '', $remoteTarget) . ".tmp";
    file_put_contents($temporaryFileName, $templateContent);

    $path = get('deploy_path') . $remoteTarget;

    // create path to template destination if not exists
    run("mkdir -p " . pathinfo($path)['dirname']);

    // upload template to remote
    upload($temporaryFileName,get('deploy_path') . $remoteTarget);
    unlink($temporaryFileName);
}

/**
 * Generate a database name
 * @param null $feature
 * @return string
 */
function getDatabaseName($feature = null): string
{
    $feature = $feature ?: input()->getOption('feature');
    $project = get('project');
    return substr(getFeatureName("{$project}--{$feature}"),0,63);
}

/**
 * @param $feature
 * @return array|string|string[]|null
 */
function getFeatureName($feature = null) {
    $feature = $feature ?: input()->getOption('feature');

    return preg_replace('/[^A-Za-z0-9\_\-.]/', '', $feature);
}