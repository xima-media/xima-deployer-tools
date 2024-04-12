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

You can extend this step by extending the `dev:tabula_rasa` task, e.g.

```php
task('dev:tabula_rasa')->addAfter(function() {
    runLocally('npm install')
});
```

### Start new release

Start a new release branch by setting a new release version (e.g. `1.2.3-RC`) and create a new release branch (e.g. `release-1.2.3`).

### Steps

You'll find the default steps within this task: `dev:release:steps`[task](../deployer/dev/task/release.php#L17).

Disable them for your needs, e.g. 

```php
task('dev:release:qa:npm')->disable();
```

### General advices

> *Always* check the automated created git commits before pushing them. 

Hint: Use the following command to link your git user into the ddev container.

```bash
ln -s ~/.gitconfig ~/.ddev/homeadditions/.gitconfig
```

## Standalone

You can execute some of the tasks of the release process as standalone tasks.

```bash
$ dep dev:tabula_rasa local
```

```bash
$ dep dev:sync local
```