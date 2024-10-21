# Changelog

All notable changes to `Credo` will be documented in this file.

## [0.6.0](https://github.com/rougin/credo/compare/v0.5.0...v0.6.0) - 2024-10-22

### Added
- `$pagee` for customizing pagination in `PaginateTrait`
- Methods in `Repository` related to CRUD operations
- `Repository::dropdown` for getting results as dropdowns
- Usage of timestamps (e.g., `CREATED_AT`, `UPDATED_AT`)
- Support the latest version of `doctrine/orm` (`~3.0`)

### Changed
- `CredoTrait::credo` returns `Credo` instance
- `Model::delete` returns a `boolean`
- Code coverage to `Codecov`
- Code documentation by `php-cs-fixer`
- Improved code quality by `phpstan`
- Simplified code structure
- Workflow to `Github Actions`

### Fixed
- Getting offset value in `PaginateTrait`

### Removed
- `__call` magic method in `Repository`

## [0.5.0](https://github.com/rougin/credo/compare/v0.4.0...v0.5.0) - 2018-12-08

> [!WARNING]
> This release will introduce a backward compatability break if upgrading from `v0.4.0` release.

### Added
- `CredoTrait`

### Changed
- `EntityRepository` (renamed as `Repository`)

### Removed
- `CodeigniterModel`
- `EntityRepository`
- `InstanceHelper`
- `MagicMethodHelper`
- `MethodHelper`
- `Model::all`

## [0.4.0](https://github.com/rougin/credo/compare/v0.3.0...v0.4.0) - 2018-09-24

### Added
- `CodeigniterModel::get`
- `CodeigniterModel::metadata`
- `CodeigniterModel::primary`
- `CodeigniterModel::table`
- `CodeigniterModel::where`
- `MethodHelper`
- `Model`
- `ValidateTrait::errors`

### Changed
- `Credo`
- `EntityRepository`
- `InstanceHelper`
- `Loader::repository`
- `PaginateTrait`
- `README.md`

### Deprecated
- `ValidateTrait::validationErrors`
- `ValidateTrait::validation_rules` (renamed as `ValidateTrait::rules`)
- `CodeigniterModel::findBy`
- `CodeigniterModel` (renamed as `Model`)
- `MagicMethodHelper` (renamed as `MethodHelper`)

### Removed
- `CodeigniterModel::getTableNameAndPrimaryKey`

## [0.3.0](https://github.com/rougin/credo/compare/v0.2.0...v0.3.0) - 2016-10-29

### Added
- `PaginateTrait` for creating pagination links using CodeIgniter's `Pagination` class

## [0.2.0](https://github.com/rougin/credo/compare/v0.1.3...v0.2.0) - 2016-10-27

### Added
- `CodeigniterModel` that extends to `CI_Model`
- `ValidateTrait` for validating data using CodeIgniter's `Form_validation` class

## [0.1.3](https://github.com/rougin/credo/compare/v0.1.1...v0.1.3) - 2016-09-05

### Changed
- Documentation
- Versions of `rougin/spark-plug` and `rougin/codeigniter`

## [0.1.2](https://github.com/rougin/credo/compare/v0.1.1...v0.1.2) - 2016-05-15

### Changed
- Version of `rougin/codeigniter` to `^3.0.0`

## [0.1.1](https://github.com/rougin/describe/compare/v0.1.0...v0.1.1) - 2015-03-24

### Changed
- Package dependencies in `composer.json`

### Fixed
- `Undefined variable: ci` issue

## 0.1.0 - 2016-03-20

### Added
- `Credo` library