# Changelog

All notable changes will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## Unreleased

### Added

- [df296de](https://github.com/matt-allan/hours/commit/df296de3fdf0e9266a776265de8c7626945c0788) Upgraded to Laravel Zero 7.0.

### Changed

- [93adbf6](https://github.com/matt-allan/hours/commit/93adbf638daf407f314129177e8cd2eae622ab23) Lowercased all keys for JSON report

### Deprecated

### Fixed

- [686ab35](https://github.com/matt-allan/hours/commit/686ab35d470fd21dfc3cfd6b67ac69fce135cb13) Hid `db:seed`, `db:wipe`, and `make:migration commands. Moved migration commands from 'removed' to 'hidden'.
- [8376afa](https://github.com/matt-allan/hours/commit/8376afa0e08f9c932816235f2a0f44c17570c891) Fixed incorrect namespaces that prevented event listeners from running.

### Removed

### Security

## v0.2.0 - 2020-06-05

### Added

- [c0d9a39](https://github.com/matt-allan/hours/commit/c0d9a399e3fb831799e3545c779b2a94962dd610) Added shell completion.
- [e15cc2c](https://github.com/matt-allan/hours/commit/e15cc2c613fa0c2195057bde9a4d49027db2c853) Added support for the `--at` flag to the  `hours stop` command.
- [a5a498f](https://github.com/matt-allan/hours/commit/a5a498fe6e4eda3e5132e5ee4a905f892b5c3dc6) Added the ability to include open frames on the report.
- [3c58bf8](https://github.com/matt-allan/hours/commit/3c58bf8ec7feca3a6ea147fa4b44a59309e10895) Added support for default projects using the `HOURS_PROJECT` environment variable or `default_project` setting. This commit also adds support for loading environment variables from a `.hours` file.
- [809724c](https://github.com/matt-allan/hours/commit/809724c07ff74329d39fa7ae0643833e279d5640) Added a `frame:list` command.
- [67ed725](https://github.com/matt-allan/hours/commit/67ed7257787a54940f566106aca3a18aa50541c8) Added a `frame:forget` command.

### Deprecated

### Fixed

- [8c5063c](https://github.com/matt-allan/hours/commit/8c5063c64f2240c65a7a0d93115e6d75956de50c) Limit interval cascades to hours and minutes. For example, this prevents the total from displaying as '0:00' if you worked a total of 24 hours.
- [9f67488](https://github.com/matt-allan/hours/commit/9f674885ac237b304ec11b410dc14fe0a094aa7f) Resolved an error that would occur if the `hours` directory did not exist in the XDG data directory.

### Removed

- [9f67488](https://github.com/matt-allan/hours/commit/9f674885ac237b304ec11b410dc14fe0a094aa7f) Dropped support for PHP 7.1.

### Security

## v0.1.0 - 2019-05-23

Initial release.
