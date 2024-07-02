# Changelog

All notable changes to this project will be documented in this file.

## [Unreleased]

## [1.1.3] - 2024-07-02

### Fixed

- potential duplicate lines in composer_update

## [1.1.2] - 2024-06-27

### Fixed

- fbd index page styles

## [1.1.1] - 2024-06-27

### Fixed

- jira api connection for feature brand deployment index page

## [1.1.0] - 2024-06-20

### Added

- database caching for 1 day after syncing it using `--cache-db` in `dev:tr`

## [1.0.6] - 2024-06-12

### Fixed

- jira urls in default feature config

## [1.0.5] - 2024-05-28

### Changed

- add post_db_sync to release task

## [1.0.4] - 2024-05-17

### Fixed

- prevent error if feature is not initialized

### Added

- option no-db-sync for tabula rasa

### Changed

- **BREAKING:** renamed newVersion option to new-version

## [1.0.3] - 2024-05-08

### Added

- adjustments of dev and debug commands for drupal

## [1.0.2] - 2024-04-22

### Fixed

- fix task naming

## [1.0.1] - 2024-04-22

### Fixed

- fix autoload merge issue

## [1.0.0] - 2024-04-19

### Changed

- add dev tasks for release preparation
  - `dev:release:prepare` to prepare a release
  - `devtr` for tabula rasa
  - `dev:sync` for syncing the database
- add debug tasks
  - `debug:ssh` for easy start a ssh session
  - `debug:db` for debugging the database
  - `debug:log:app` for debugging the app log

### Fixed

- add "/public/upload" to writable_dirs for symfony

## [0.3.5] - 2024-03-25

### Fixed

- deletion of multiple feature branches in `feature:cleanup`

### Changed

- use rsync option within db_sync_tool as default

## [0.3.4] - 2024-02-28

### Added

- real time log output for drupal and typo3

## [0.3.3] - 2024-02-15

### Fixed

- set picocss to 1.5.12 for feature index pages
- set default keep releases to 2 for typo3/drupal deployment
- remove typo3 specific rsync settings
- fix drupal sync source

## [0.3.2] - 2024-02-14

### Fixed

- adjust typo3 rsync default excludes

## [0.3.1] - 2023-12-21

### Added

- add symfony mailer config to settings.local.php.dist for drupal

### Fixed

- change default jira path
- security check for composer dependencies

## [0.3.0] - 2023-12-05

### Change

- **Breaking:** drupal drush default path to a relative one (`../../../vendor/bin/drush`)

### Fixed

- database backup to use the correct one

## [0.2.6] - 2023-11-10

### Added

- move default rsync excludes to deployer setting

### Fixed

- typo3: remove htaccess from shared files in default config
- define own rsync typo3 settings

## [0.2.5] - 2023-10-23

### Fixed

- drupal deploy.php.dist file

## [0.2.4] - 2023-08-29

### Added

- config variable `drush` to override the drush path (defaults to `which('drush')`)

## [0.2.3] - 2023-08-29

### Added

-  symfony default writable configuration

### Fixed

- jira issue assignee of not assigned
- php direction location mismatch of symlinks

## [0.2.2] - 2023-08-28

### Added

-  add more security mechanism for feature deletion / feature cleanup

### Fixed

- Symfony autoload generation

## [0.2.1] - 2023-08-25

### Added

-  configuration `feature_stop_disallowed_names` for `feature:stop`

## [0.2.0] - 2023-08-25

### Changed

-  `feature:stop` to  support downstream pipelining

## [0.1.6] - 2023-08-17

### Fixed

- Drupal cache clearing

## [0.1.5] - 2023-08-17

### Fixed

- Drupal autoload generation

## [0.1.4] - 2023-06-22

### Fixed

- build asset task for symfony deployments

## [0.1.3] - 2023-06-21

### Fixed

- re-enable build tasks within symfony deployment

## [0.1.2] - 2023-06-09

### Added

- extended run function for global configuration
- adjust the following deployments: feature, symfony, typo3, drupal

## [0.1.1] - 2023-06-01

### Added

- real time output for drupal tasks

### Fixed

- drupal autoloading so that web_path config parameter is configured in `set.php` and doesn't need to be set on project level

## [0.1.0] - 2023-05-25

### Added

- initial version
