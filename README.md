XIMA Deployer Tools
===
> The XIMA Deployer Tools combine multiple [deployer](https://deployer.org/) recipes for an improved deployment process and workflow.

- [Installation](#installation)
- [Feature Branch Deployment](#feature-branch-deployment)
- [Symfony](#symfony)
- [TYPO3](#typo3)
- [Drupal](#drupal)
- [Standalone Tasks](#standalone-tasks)

The focus relies on reusable concluded tasks and the possibility to combine multiple deployment workflows, e.g. [Symfony](#symfony) and [Feature Branch Deployment](#feature-branch-deployment). 

- predefined **deployment workflows** for *TYPO3*, *Symfony* and *Drupal* applications
- compact **feature branch deployment** 
- useful **standalone tasks** for extending existing workflows

# Installation

Install the XIMA Deployer Tools via composer:
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

The TYPO3 deployment covers the deployment process for TYPO3 CMS applications.

Read the [documentation](docs/TYPO3.md) for detailed installation instructions and further explanations.

# Drupal

The Drupal deployment covers the deployment process for Drupal CMS applications.

Read the [documentation](docs/DRUPAL.md) for detailed installation instructions and further explanations.


# Standalone Tasks
- MS Teams Notification
- Database backup
- [Security check](docs/SECURITY.md)
- [Release preparation](docs/RELEASE.md)
