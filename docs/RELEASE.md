# Release preparation

The following task should partly automate the release preparation steps.

## General

Start the new release task.

```bash
$ dep dev:release local
```

Define the new release number within the prompt or use `--newVersion=1.2.3`.

Use the following command to reset the new release branch (in case of an occurring error):

```bash
$ dep dev:release:reset local
```

Use the following command to finish the new release branch:

```bash
$ dep dev:release:finish local
```

## Concept

The following steps will be performed:

### Check preconditions

Check if the local state is clean to execute all the following steps.

### Tabula rasa

Check out the default branch (e.g. `main`) and run commands to restore the standard status (e.g. `composer install`).

You can extend this step with a callback of the `dev_tabula_rasa_callback` variable, e.g.

```php
set('dev_tabula_rasa_callback', function() {
    runLocally('npm install')
})
```

### Start new release

Start a new release branch by setting a new release version (e.g. `1.2.3-RC`) and create a new release branch (e.g. `release-1.2.3`).

### Composer install

ToDo

### Adjust steps

Extend or reduce the steps within the release preparation by adjust the `dev:release:steps`[task](../deployer/dev/task/release.php#L17).

### Advices

> Check the automated created git commits before pushing them. 

Hint: Use the following command to link your git user into the ddev container.

```bash
ln -s ~/.gitconfig ~/.ddev/homeadditions/.gitconfig
```