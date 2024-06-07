# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.3.2] - 2024-06-07

### Commits

- Move PHPStan and Psalm from vendor-bin directory. ([900dd94](https://github.com/pronamic/wp-number/commit/900dd944a8709ee7380e131963c0362481e9728a))
- Coding standards. ([af59d9c](https://github.com/pronamic/wp-number/commit/af59d9ced7fdc99d29a8905001e34285c5e18439))
- Added test for https://github.com/pronamic/wp-pronamic-pay-gravityforms/issues/40#issuecomment-2106892669. ([1bd35aa](https://github.com/pronamic/wp-number/commit/1bd35aacb21c7fb22ecb768f596ee853e1e3b2a9))

Full set of changes: [`1.3.1...1.3.2`][1.3.2]

[1.3.2]: https://github.com/pronamic/wp-number/compare/v1.3.1...v1.3.2

## [1.3.1] - 2024-05-15

### Commits

- Fixed "Deprecated: Calling ReflectionProperty::setValue() with a single argument is deprecated". ([803e7d7](https://github.com/pronamic/wp-number/commit/803e7d7257aa751a525daa21ab6ac98cb414c664))
- Fixed "All output should be run through an escaping function". ([754b9da](https://github.com/pronamic/wp-number/commit/754b9da30b383afb982dc3d9c52fa1118df86790))
- Fixed "It is recommended not to use reserved keyword "string" as function parameter name. Found: $string". ([a903388](https://github.com/pronamic/wp-number/commit/a90338889b20992b35898675456e033629e6236d))
- Fixed "It is recommended not to use reserved keyword "string" as function parameter name. Found: $string". ([52a8a30](https://github.com/pronamic/wp-number/commit/52a8a309a1bbd205175049b1390a19b540fdab59))
- Updated composer.json ([70aa3de](https://github.com/pronamic/wp-number/commit/70aa3dee3d6a03d222d501f3c2bc1892866fa23d))

Full set of changes: [`1.3.0...1.3.1`][1.3.1]

[1.3.1]: https://github.com/pronamic/wp-number/compare/v1.3.0...v1.3.1

## [1.3.0] - 2023-03-21

### Commits

- Set Composer type to "wordpress-plugin". ([6383fcf](https://github.com/pronamic/wp-number/commit/6383fcf30160b6860156fc9b2b1511b0d123973f))
- Added `negative` function. ([9cf872b](https://github.com/pronamic/wp-number/commit/9cf872b3ed7eadfbe36e8b665b1e722a27e1a957))
- Use Yoast/PHPUnit-Polyfills. ([461fdd9](https://github.com/pronamic/wp-number/commit/461fdd978d90a6c9a66e62fb2f7ae0d26304b7b1))
- Created .gitattributes ([1627e69](https://github.com/pronamic/wp-number/commit/1627e691c82b0249f266e01b9e2bf78d0e026c1a))

Full set of changes: [`1.2.1...1.3.0`][1.3.0]

[1.3.0]: https://github.com/pronamic/wp-number/compare/v1.2.1...v1.3.0

## [1.2.1] - 2023-01-31
### Composer

- Changed `php` from `>=8.0` to `>=7.4`.
Full set of changes: [`1.2.0...1.2.1`][1.2.1]

[1.2.1]: https://github.com/pronamic/wp-number/compare/v1.2.0...v1.2.1

## [1.2.0] - 2022-12-19
- Increased minimum PHP version to version `8` or higher.
- Improved support for PHP `8.1` and `8.2`.
- Removed usage of deprecated constant `FILTER_SANITIZE_STRING`.

Full set of changes: [`1.1.1...1.2.0`][1.2.0]

[1.2.0]: https://github.com/pronamic/wp-number/compare/1.1.1...1.2.0

## [1.1.1] - 2022-09-23
- Coding standards.

## [1.1.0] - 2022-01-10
### Changed
- Improved precision support [pronamic/wp-pronamic-pay#281](https://github.com/pronamic/wp-pronamic-pay/issues/281).

## [1.0.1] - 2021-09-30
- Added number parser.

## [1.0.0] - 2021-07-02
### Added
- First release.

[Unreleased]: https://github.com/pronamic/wp-number/compare/1.1.1...HEAD
[1.1.0]: https://github.com/pronamic/wp-number/compare/1.0.1...1.1.0
[1.0.1]: https://github.com/pronamic/wp-number/compare/1.0.0...1.0.1
[1.0.0]: https://github.com/pronamic/wp-number/releases/tag/1.0.0
