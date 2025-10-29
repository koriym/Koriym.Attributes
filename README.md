# Koriym.Attributes

[![codecov](https://codecov.io/gh/koriym/Koriym.Attributes/branch/master/graph/badge.svg?token=O1MBvJrlP6)](https://codecov.io/gh/koriym/Koriym.Attributes)
[![Type Coverage](https://shepherd.dev/github/koriym/Koriym.Attributes/coverage.svg)](https://shepherd.dev/github/koriym/Koriym.Attributes)
![Continuous Integration](https://github.com/koriym/Koriym.Attributes/workflows/Continuous%20Integration/badge.svg)
![Static Analysis](https://github.com/koriym/Koriym.Attributes/workflows/Static%20Analysis/badge.svg)
![Coding Standards](https://github.com/koriym/Koriym.Attributes/workflows/Coding%20Standards/badge.svg)

A PHP 8 attribute reader that provides a familiar interface compatible with the `doctrine/annotations` Reader pattern.

## Why use this library?

This library serves two purposes:

**1. Migration tool** - The `doctrine/annotations` library has been [abandoned](https://github.com/doctrine/annotations) as PHP 8 introduced native attributes. This library provides a smooth migration path from Doctrine Annotations to native PHP 8 attributes with minimal code changes.

**2. Architectural pattern** - Provides an abstraction layer for dependency injection, testability, and extensibility. Your code depends on `AttributeReaderInterface`, not directly on PHP's Reflection API.

### What's new in 2.x?

- Removed `doctrine/annotations` dependency (no longer needed)
- Removed `DualReader` class (PHP 8+ only)
- Requires PHP 8.1+ (taking full advantage of native attributes)
- Modern type hints with union types

## Installation

    composer require koriym/attributes ^2.0

## Requirements

- PHP 8.1 or later

## Usage

Create an `AttributeReader` instance:

```php
use Koriym\Attributes\AttributeReader;
use Koriym\Attributes\AttributeReaderInterface;

$reader = new AttributeReader();
```

The reader provides methods for reading PHP 8 attributes with the familiar Reader interface:

```php
// Read class attributes
$classAttributes = $reader->getClassAnnotations($reflection);
$specificAttribute = $reader->getClassAnnotation($reflection, MyAttribute::class);

// Read method attributes
$methodAttributes = $reader->getMethodAnnotations($reflection);
$specificAttribute = $reader->getMethodAnnotation($reflection, MyAttribute::class);

// Read property attributes
$propertyAttributes = $reader->getPropertyAnnotations($reflection);
$specificAttribute = $reader->getPropertyAnnotation($reflection, MyAttribute::class);
```

## Migration Guide

### Automated Migration with Rector

The easiest way to migrate is using [Rector](https://getrector.com/), following [Doctrine's migration approach](https://www.doctrine-project.org/2022/11/04/annotations-to-attributes.html):

1. **Install Rector and Doctrine rules:**
   ```bash
   composer require --dev rector/rector rector/rector-doctrine
   ```

2. **Download the migration config:**
   ```bash
   curl -O https://raw.githubusercontent.com/koriym/Koriym.Attributes/2.x/rector-migrate.php
   ```

3. **Run the migration:**
   ```bash
   vendor/bin/rector process --config=rector-migrate.php
   ```

   This will automatically:
   - Convert Doctrine annotations to PHP 8 attributes (`@Route` → `#[Route]`)
   - Replace `Reader` with `AttributeReaderInterface`
   - Replace `DualReader` with `AttributeReader`

4. **Review and test:**
   - Review the changes made by Rector
   - Run your tests to ensure everything works
   - If you have custom `AttributeReaderInterface` implementations, manually add `string` type to `$annotationName` parameters

5. **Clean up (optional):**
   ```bash
   composer remove --dev rector/rector rector/rector-doctrine
   rm rector-migrate.php
   ```

**Reference:** See [Doctrine's annotations-to-attributes migration guide](https://www.doctrine-project.org/2022/11/04/annotations-to-attributes.html) for more details on annotation conversion.

### Manual Migration

If your codebase currently uses `Doctrine\Common\Annotations\Reader`, you can migrate manually:

```diff
-use Doctrine\Common\Annotations\Reader;
+use Koriym\Attributes\AttributeReaderInterface;

-public function __construct(Reader $reader)
+public function __construct(AttributeReaderInterface $reader)
{
    $this->reader = $reader;
}
```

**If you have custom implementations** of the reader interface, add explicit `string` type:

```diff
 use Koriym\Attributes\AttributeReaderInterface;

 class MyCustomReader implements AttributeReaderInterface
 {
-    public function getClassAnnotation(ReflectionClass $class, $annotationName): object|null
+    public function getClassAnnotation(ReflectionClass $class, string $annotationName): object|null
     {
         // your implementation
     }

+    // Same for getMethodAnnotation() and getPropertyAnnotation()
 }
```

For most users (those consuming the interface, not implementing it), your existing code continues to work without changes.
