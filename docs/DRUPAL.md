# Drupal Deployment

The Drupal documentation describes the deployment and initialization process of a TYPO3 CMS application.

> The deployment package is inspired by [deployer-extended-typo3](https://github.com/sourcebroker/deployer-extended-typo3).

* [Installation](#installation)
* [Tasks](#tasks)
  + [Clear the cache](#clear-the-cache)
  + [Import the drupal configuration](#import-the-drupal-configuration)
  + [Update the database](#updat-the-database)
  + [Sync the database from another drupal instance](#sync-the-database-from-another-drupal-instance)
  + [Backup the database](#backup-the-database)
  + [Sync the files from another drupal instance](#sync-the-files-from-another-drupal-instance)
  + [Enable/disable the maintenance mode](#enabledisable-the-maintenance-mode)
  + [Permission handling](#permission-handling)
  + [Update the drupal translations](#update-the-drupal-translations)


The deployment workflow uses the deployer package [deployer-extended](https://github.com/sourcebroker/deployer-extended) as basis. 

## Installation

The default configuration for Drupal applications is located at [set.php](../deployer/drupal/config/set.php) and can be overwritten optionally.

If you want to use the Drupal deployment functionalities add the belonging autoloader to your project `deploy.php`:

```php
require_once(__DIR__ . '/vendor/xima/xima-deployer-tools/deployer/drupal/autoload.php');
```

See an example configuration here: [drupal example](../deployer/drupal/example/).

## Tasks

The following tasks are Drupal specific and extend the default deployer deployment:

### Default deployment

The default deployment task for Drupal applications can be found here  [deploy.php](../deployer/drupal/task/deploy.php)

### Clear the cache

This task calls `drush cache-rebuild`.

```bash
dep deploy:cache:clear
```

### Import the drupal configuration

This task calls `drush cim`.

```bash
dep deploy:configuration:import
```

### Update the database

This task calls `drush updb`.

```bash
dep deploy:database:update
```

### Sync the database from another drupal instance

This task needs to have the deployer argument `sync` in place. Pass in a drush site alias as you normally would when executing `drush:sync`. The drupal instance referenced by this alias acts as the sync source.

Typically this task is used in the feature branch deployment workflow.

```bash
dep deploy:database:sync --sync=about.master-stage
```

### Backup the database

Uses drush's backup functionality. Typically this task is used in the production deployment. Also cleans up the drush backups keeping a maximum of 10 backups.

```bash
dep deploy:database:backup
```

### Sync the files from another drupal instance

This task needs to have the deployer argument `sync` in place. Pass in a drush site alias as you normally would when executing `drush:sync`. The drupal instance referenced by this alias acts as the sync source.

Typically this task is used in the feature branch deployment workflow.

```bash
dep deploy:files:sync --sync=about.master-stage
```

### Backup the database

This task creates a `logs` directory in the `private` folder. Can be used e.g. for [monolog](https://www.drupal.org/project/monolog) logging.

```bash
dep deploy:log_dir:create
```

### Enable/disable the maintenance mode

This task uses drush to enable/disable the maintenance mode.

```bash
dep deploy:maintenance:enable
dep deploy:maintenance:disable
```

### Permission handling

Sets reasonable permissions for the project directory and the files folder.

```bash
dep deploy:permissions:drupal
dep deploy:permissions:drupal_files
```

### Update the drupal translations

This task calls `drush locale:update`.

```bash
dep deploy:translations:update
```
