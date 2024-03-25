<?php

namespace Xima\XimaDeployerTools\Utility;


use function Deployer\askHiddenResponse;
use function Deployer\get;
use function Deployer\has;
use function Deployer\set;

class VarUtility {

    /**
     * Get the database variable by app type
     *
     * @param string $var
     * @return string|bool
     */
    public static function getDatabaseVarByType(string $var = 'password'): string|bool
    {
        $var = ucfirst($var);
        $type = ucfirst(get('app_type'));
        $functionName = "getDatabase{$var}By{$type}";
        switch ($type) {
            case 'Typo3':
                require_once(__DIR__ . '/../../deployer/typo3/task/deploy_database.php');
                break;
            case 'Drupal':
                require_once(__DIR__ . '/../../deployer/drupal/task/deploy_database.php');
                break;
            case 'Symfony':
                require_once(__DIR__ . '/../../deployer/symfony/task/deploy_database.php');
                break;
        }
        if (function_exists($functionName)) {
            return call_user_func($functionName);
        }
        return false;
    }


    /**
     * Get the database password for the feature branch
     *
     * @return string
     * @throws \Deployer\Exception\Exception
     * @throws \Deployer\Exception\WillAskUser
     */
    public static function getDatabasePassword(): string {
        $databaseUser = get('database_user');
        $databaseHost = get('database_host');
        $databasePassword = has('database_password') ? get('database_password') : getenv('DEPLOYER_CONFIG_DATABASE_PASSWORD');

        if (!$databasePassword) {
            $databasePassword = VarUtility::getDatabaseVarByType();
        }

        if (!$databasePassword) {
            $databasePassword = askHiddenResponse("Enter the database password for $databaseUser@$databaseHost:");
            set('database_password', $databasePassword);
        }
        return $databasePassword;
    }
}
