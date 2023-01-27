XIMA Deployer Tools
===
> The XIMA Deployer Tools combine multiple [deployer](https://deployer.org/) recipes for an improved deployment process and workflow.

<!-- TOC start -->
- [Feature Branch Deployment](#feature-branch-deployment)
    + [Prerequirements](#prerequirements)
    + [Initialization](#initialization)
    + [Deletion](#deletion)
    + [Notification](#notification)
    + [Synchronization](#synchronization)
    + [Information](#information)
    + [Pathing](#pathing)
    + [Cleanup](#cleanup)
    + [Further more](#further-more)
- [TYPO3](#typo3)
- [rsync](#rsync)
- [deploy](#deploy)
- [ToDo](#todo)
<!-- TOC end -->

# Feature Branch Deployment

The feature branch deployment describes the deployment and initialization process of multiple application instances on the same host.

If you want to use the feature branch deployment functionalities add the belonging autoloader to your project `deploy.php`:

```php
require_once(__DIR__ . '/vendor/xima/xima-deployer-tools/deployer/feature/autoload.php');
```

See an example configuration here: [deploy.php](deployer/feature/example/deploy.php).

The following steps are necessary to successfully setup the deployment workflow:

### Prerequirements

You need a database user with the following grants to dynamically create and delete new databases:

- `SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, ALTER, CREATE TEMPORARY TABLES, LOCK TABLES, EXECUTE, CREATE VIEW, SHOW VIEW, CREATE ROUTINE, ALTER ROUTINE`

### Initialization

The `feature:setup` command represent the initialization of a new feature branch. It creates the necessary folder structure and database for the application. Also it extend the given host information with the necessary dynamic feature instance information.

```bash
$ vendor/bin/dep feature:setup stage --feature=TEST-01
```

This task should be declared to run at first within your deploy task:

```php
before('deploy:info', 'feature:setup';
```

If the application needs to setup additional configuration files for e.g. storing the database credentials, use the feature templates to provide this kind of dynamic setup. For example the TYPO3 setup with a `.env` file:

```php
set('feature_templates', [
    __DIR__ . '/.deployment/deployer/templates/.env.dist' => '/shared/.env'
]);
```

This configuration defines the local template file as well as the remote target destination. Within the template file a bunch of predefined variables are available and can be placed with `{{attribute}}`.

| attribute                       | description                                                                          |
|---------------------------------|--------------------------------------------------------------------------------------|
| `DEPLOYER_CONFIG_DATABASE_HOST` | default is `127.0.0.1`, overwrite with deployer `set('database_host', '127.0.0.1');` |
| `DEPLOYER_CONFIG_DATABASE_PORT` | default is `3306`, overwrite with deployer `set('database_port', '3306');`           |
| `DEPLOYER_CONFIG_DATABASE_USER` | should be defined with `database_user` in the host configuration                     |
| `DEPLOYER_CONFIG_DATABASE_NAME` | will be dynamically generated                                                        |
| `DEPLOYER_CONFIG_FEATURE_NAME`  | will be provide with the `--feature=` command line argument                          |
| `DEPLOYER_CONFIG_FEATURE_URL`   | will be dynamically generated                                                        |
| `DEPLOYER_CONFIG_FEATURE_PATH`  | will be dynamically generated                                                        |

You can extend these list be providing more environment variables starting with `DEPLOYER_CONFIG_*`.

> Hint: If you're using other deployer commands within the feature branch deployment context, you should use the `feature:init` task to extend the host definition with the necessary feature instance configuration:
>
> ```php
> before('deploy:rollback', 'feature:init');
> ```

### Deletion

The `feature:stop` command deletes the feature branch instance, including the folder structure and the database.

```bash
$ vendor/bin/dep feature:stop stage --feature=TEST-01
```

### Notification

The `feature:notify` command notifies about a successful initial feature branch deployment and can be configured with the following settings:

```php
set('feature_msteams_color', '#0097A7');
set('feature_msteams_text', 'Der Branch **[{{feature}}]({{public_url}})** wurde bereitgestellt.');
```

This task should be placed right before finishing the deployment task.
```php
before('deploy:success', 'feature:notify';
```

> Hint: it is possible to mute the notification by providing the environment variable `DEPLOYER_CONFIG_NOTIFICATION_MUTE`.

### Synchronization
The `feature:sync` command synchronizes the feature branch instance with data from a different instance using the [db-sync-tool](https://github.com/jackd248/db-sync-tool).

_ToDo_

### Information

The `feature:list` command lists all available feature branches:

```bash
$ vendor/bin/dep feature:list

+----------------+------------------ stage ------------------------------------+
| Feature Branch | Modification Date | Public URL                              |
+----------------+-------------------+-----------------------------------------+
| feature-start  | 20.01.2023 15:07  | https://test.xima.local/feature-start   |
| test           | 20.01.2023 17:45  | https://test.xima.local/test            |
+----------------+-------------------+-----------------------------------------+
```

Also a simple feature branch overview index file can be placed on the hosts with the `feature:index` command:

```bash
$ vendor/bin/dep feature:index stage
```

### Pathing

Normally the feature instances are deployed in the web root of the host, e.g. `/var/www/html/`. But the entry point of an application could lie in a nested folder structure, e.g. `/var/www/html/app/current/public/`, so the url would look like this: `https://test.local/app/current/public/`.

To make this a bit easier, you can use the `feature:urlshortener` command. Initially activate the function via:

```php
set('feature_url_shortener', true);
```

```php
after('deploy:symlink', 'feature:urlshortener';
```

The folder structure on the server will look like this:

```bash
├── .dep
│   └── instances
│       ├── app
│       │   └── current
│       │       └── public/
│       └── ...
└── app -> .dep/instances/app/current/public

```

So the resulting url will look like: `https://test.local/app`.

### Cleanup

The `feature:cleanup` command helps to cleanup feature branch instances. It compares remote git branches with remote feature instances and provides a cleanup for all untracked feature instances on the remote server.

```bash
$  vendor/bin/dep feature:cleanup
task feature:cleanup
+------------------- stage -------------------+
| Remote Git Branch | Remote Feature Instance |
+-------------------+-------------------------+
| main              | main                    |
| stage             | stage                   |
|                   | test                    |
+-------------------+-------------------------+
[stage] Do you want to cleanup all remote feature instances which haven't an according git branch anymore? (marked as red) [y/N] y
[stage] info feature branch test deleted
```

### Further more

Additional configurations regarding the feature branch deployment are available here: [set.php](deployer/config/set.php)


# TYPO3

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

# rsync

Following the rsync strategy there are predefined, ready to use rsync tasks using the package contrib/rsync.php.

You can overwrite the source dir:
- 'rsync_src'
  and even the whole rsync configuration:
- 'rsync'

`Excludes are red from 'deployment/rsync/exclude.txt' by default.`

# deploy

The predefined 'deploy' tasks runs with ready to use feature branch deployment and rsync.

There is also a ready to use 'rollback' task.

# ToDo
- MS Teams Notification
