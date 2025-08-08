# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.7] - 2025-08-08

### Fixed
- Fixed infinite recursion issue in DualReader when using multiple complex attributes ([#26](https://github.com/koriym/Koriym.Attributes/issues/26))
- Implemented early return optimization to avoid `array_unique()` recursion when no Doctrine annotations are present

### Added
- Comprehensive regression test suite for Issue #26 with 100% code coverage
- PHP 7.2 compatibility improvements in test suite
- Additional test fixtures for better code organization

### Changed
- Improved code organization by separating test fixtures into dedicated files
- Added `.claude/` to gitignore to prevent tracking of IDE configuration files

## [1.0.6] - Previous release