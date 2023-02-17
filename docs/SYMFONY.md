# Symfony Deployment

The symfony deployment describes the deployment and initialization process of a symfony application.

> The deployment package is inspired by [deployer-extended-symfony5](https://github.com/sourcebroker/deployer-extended-symfony5).

If you want to use the symfony deployment functionalities add the belonging autoloader to your project `deploy.php`:

```php
require_once(__DIR__ . '/vendor/xima/xima-deployer-tools/deployer/symfony/autoload.php');
```

See an example configuration here: [deploy.php](deployer/symfony/example/deploy.php).

## Tasks

The following tasks are symfony specific and extend the default deployer deployment:

### Clearing the cache

The symfony cache can be cleared with the following task:

```bash
dep deploy:cache:clear
```

### Warming the cache

The symfony cache can be warmed with the following task:

```bash
dep deploy:cache:warmup
```

### Updating the database

The symfony database can be updated with the following task:

```bash
dep deploy:database:update
```

> Notice: The updating method can be configured with the `deploy_database_update_method` parameter (`migrations_migrate`|`schema_update`).