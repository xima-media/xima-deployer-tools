XIMA Deployer Tools
===
> The XIMA Deployer Tools combine multiple [deployer](https://deployer.org/) recipes for an improved deployment process and workflow.

- [Installation](#installation)
- [Feature Branch Deployment](#feature-branch-deployment)
- [Symfony](#symfony)
- [TYPO3](#typo3)
  * [deploy](#deploy)
  * [rsync](#rsync)
- [Drupal](#drupal)
- [Standalone Tasks](#standalone-tasks)

The focus relies on reusable concluded tasks and the possibility to combine multiple deployment workflows, e.g. [Symfony](#symfony) and [Feature Branch Deployment](#feature-branch-deployment). 

- predefined **deployment workflows** for *TYPO3*, *Symfony* and *Drupal* applications
- compact **feature branch deployment** 
- useful **standalone tasks** for extending existing workflows

# Installation

The package is available via the [XIMA Satis](https://satis.xima.de/).

Add the following [repository](https://getcomposer.org/doc/05-repositories.md#composer) to your `composer.json`:

```json
{
  "repositories": [
    {
      "type": "composer",
      "url": "https://satis.xima.de"
    }
  ]
}
```

Afterwards install the XIMA Deployer Tools via composer:
```bash
composer require xima/xima-deployer-tools
```

Now you can adjust the `deploy.php` with the following features:

# Feature Branch Deployment

The feature branch deployment describes the deployment and initialization process of multiple application instances on the same host.

Read the [documentation](docs/FEATURE.md) for detailed installation instructions and further explanations. 

# Symfony

The symfony deployment covers the deployment process for symfony applications.

Read the [documentation](docs/SYMFONY.md) for detailed installation instructions and further explanations.

# TYPO3

> ToDo: restructure tasks

This packages comes with a set of predefined settings and tasks for TYPO3 following the rsync strategy.

Predefined settings are (these can be overwritten in your project deployer.php):
- 'web_path'
- 'bin/typo3cms'
- 'shared_dirs'
- 'shared_files'
- 'writable_dirs'

Predefined tasks are (can be overwritten as well):
- 'typo3cms:setup' - some TYPO3 setup commands like fixfolderstructure
- 'typo3cms:database:updateschema'
- 'typo3cms:cache:flushandwarmup' - flushes all caches and warms up system caches
- 'typo3cms:cache:flushfrontend' - flushes frontend caches only

## deploy

The predefined 'deploy' tasks runs with ready to use feature branch deployment and rsync.

There is also a ready to use 'rollback' task.

## rsync

Following the rsync strategy there are predefined, ready to use rsync tasks using the package contrib/rsync.php.

You can overwrite the source dir:
- 'rsync_src'
  and even the whole rsync configuration:
- 'rsync'

`Excludes are red from 'deployment/rsync/exclude.txt' by default.`

# Drupal

> ToDo

# Standalone Tasks
- MS Teams Notification
- Database backup
- Security check (ToDo)
