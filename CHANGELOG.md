# Changelog

All notable changes to this package will be documented in this file

## [v0.5.0] - 2020-12-30
### Added
- PHP 8 support
### Removed
- Laravel 6.0 support

## [v0.4.0] - 2020-09-09
### Added
- Laravel 8.0 support

## 0.3.0 - 2020-08-04
### Changed
- The methods to return a resource rule set's common/creation/update rules for an individual field have been dropped. Instead, the existing `rules()`, `creationRules()`, and `updateRules()` methods can be used but a *key* can be passed in as an argument.

## 0.2.0 - 2020-03-04
### Added
- Laravel 7.0 support
### Removed
- pre-Laravel 6.0 support
