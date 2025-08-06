# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is `koriym/attributes`, a PHP library that provides a dual reader for both Doctrine annotations and PHP 8 attributes. The library implements the `doctrine/annotations` Reader interface to enable forward-compatible code that works with both PHP 7.x annotations and PHP 8.x attributes.

## Core Architecture

The library consists of two main components:

- **AttributeReader** (`src/AttributeReader.php`): Reads PHP 8 native attributes using the ReflectionAttribute API
- **DualReader** (`src/DualReader.php`): Composite reader that combines annotation and attribute reading, with PHP version detection to optimize behavior

The DualReader prioritizes attributes over annotations when running on PHP 8+, falling back to annotations for compatibility.

## Development Commands

### Testing
- `composer test` - Run PHPUnit tests
- `composer tests` - Run complete test suite (coding standards + tests + static analysis)
- `composer coverage` - Generate coverage report with Xdebug
- `composer pcov` - Generate coverage report with PCOV (faster)

### Code Quality
- `composer cs` - Check coding standards with PHP_CodeSniffer
- `composer cs-fix` - Fix coding standard violations
- `composer sa` - Run static analysis (PHPStan + Psalm)
- `composer clean` - Clear static analysis caches

### Build Process
- `composer build` - Complete build process (cs + sa + pcov + metrics)
- `composer metrics` - Generate code metrics report

## Code Standards

- **PHP Version**: Supports PHP 7.2+ and 8.0+
- **Strict Types**: All files use `declare(strict_types=1)`
- **Type Safety**: Extensive use of generics and type annotations for both PHPStan and Psalm
- **Exception Handling**: Custom exception hierarchy under `Koriym\Attributes\Exception\`

## Testing Architecture

Tests are organized by component:
- `tests/AttributeReader/` - Tests for PHP 8 attribute reading
- `tests/DualReaderTest.php` - Tests for dual reading functionality  
- `tests/Fake/` - Mock annotations and attributes for testing

The test suite validates compatibility between doctrine/annotation and PHP 8 attributes using fake classes that implement both paradigms.

## Key Implementation Details

- **Version Detection**: Uses `PHP_VERSION_ID >= 80000` to detect PHP 8+ support
- **Dual Compatibility**: Annotations and attributes can coexist; DualReader merges results with `array_unique()`
- **Type Templates**: Extensive use of `@template T of object` for type-safe annotation/attribute retrieval
- **ReflectionAttribute Integration**: Direct use of PHP 8's ReflectionAttribute API when available