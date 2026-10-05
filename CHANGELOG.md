# Changelog

All notable changes to this project are documented here. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and the project
adheres to [Semantic Versioning](https://semver.org/).

## [2.0.0] - Unreleased

`MetadataInterface` now declares native return types, which is a breaking
change for every implementer. See [UPGRADE-2.0.md](UPGRADE-2.0.md).

### Changed

- Requires PHP 8.3, 8.4 or 8.5. PHP 8.0, 8.1 and 8.2 are no longer supported.
- `getMetaTitle()`, `getMetaDescription()` and `getMetaImage()` declare a
  native `?string` return type.
- The docblocks of `getMetaModified()` and `getMetaPublish()` no longer claim
  `@return string`; both return `?DateTimeInterface`, as their native types
  always said.
- The interface is documented as `@api`, with what each value is used for.

### Added

- Continuous integration on PHP 8.3, 8.4 and 8.5 against lowest, locked and
  latest dependencies, with coverage reported to Codecov.
- A unit test suite that pins the interface's signatures, with a reference
  implementation in `tests/TestAsset/PageMetadata.php`.
- `LICENSE.md` with the BSD-3-Clause text the package was already declared under.

### Removed

- The `laminas/laminas-mvc` requirement. The interface never used it; projects
  that rely on laminas-mvc must require it themselves.
- `laminas/laminas-coding-standard` and `phpcs.xml`, replaced by Mago via
  `php-db/phpdb-qa-tools`.

## [1.0.2] - 2026-05-15

- Removed the incorrect `extra.laminas.component` declaration.

## [1.0.1] - 2023-12-15

- Dropped PHP 7.x support (`php: ^8.0.0`).

## [1.0.0] - 2023-04-24

- Initial release: `MetadataInterface`.
