# Release preparation

The following task should partly automate the release preparation steps.

## General



```bash
$ dep develop:release:prepare local --newVersion=1.2.3
```

Use the following command to reset the new release branch (in case of an occurring error):

```bash
$ dep develop:release:reset local --newVersion=1.2.3
```

## Concept

The following steps will be performed:

### Check preconditions

Check if the local state is clean to execute all the following steps.

### Tabula rasa

Check out the default branch (e.g. `main`) and run commands to restore the standard status (e.g. `composer install`).

You can extend this step with a callback of the `develop_tabula_rasa_callback` variable, e.g.

```php
set('develop_tabula_rasa_callback', function() {
    runLocally('npm install')
})
```

### Start new release

Start a new release branch by setting a new release version (e.g. `1.2.3-RC`) and create a new release branch (e.g. `release-1.2.3`).

### Composer install

ToDo

### Further steps

See [set.php](../deployer/develop/config/set.php) for activate/deactivate the possible steps within the release preparation or use the `develop_release_callback` function callback for own customization. 

### Finish

> Check the automated created git commits before pushing them. 