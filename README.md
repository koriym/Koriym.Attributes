# Koriym.Attributes

[![codecov](https://codecov.io/gh/koriym/Koriym.Attributes/branch/master/graph/badge.svg?token=O1MBvJrlP6)](https://codecov.io/gh/koriym/Koriym.Attributes)
[![Type Coverage](https://shepherd.dev/github/koriym/Koriym.Attributes/coverage.svg)](https://shepherd.dev/github/koriym/Koriym.Attributes)
![Continuous Integration](https://github.com/koriym/Koriym.Attributes/workflows/Continuous%20Integration/badge.svg)
![Static Analysis](https://github.com/koriym/Koriym.Attributes/workflows/Static%20Analysis/badge.svg)
![Coding Standards](https://github.com/koriym/Koriym.Attributes/workflows/Coding%20Standards/badge.svg)

A PHP 8 attribute reader that provides a familiar interface compatible with `doctrine/annotations` Reader interface.

This library serves two purposes:
1. **Migration tool** - Smooth transition from Doctrine Annotations to native PHP 8 attributes
2. **Architectural pattern** - Abstraction layer for dependency injection, testability, and extensibility

## Why version 2.x?

The `doctrine/annotations` library has been [abandoned](https://github.com/doctrine/annotations) as PHP 8 introduced native attributes. However, many existing codebases still rely on the `Reader` interface pattern.

Version 2.x was created to:
- Remove the abandoned `doctrine/annotations` dependency
- Provide a smooth migration path for existing code
- Maintain the familiar `Reader` interface that developers already know
- Support only PHP 8.1+, taking full advantage of native attributes

This allows you to migrate from Doctrine annotations to native PHP 8 attributes with minimal code changes.

## Installation

    composer require koriym/attributes ^2.0

## Requirements

- PHP 8.1 or later

## Usage

Create the reader instance.

```php
use Koriym\Attributes\AttributeReader;
use Koriym\Attributes\AttributeReaderInterface;

$reader = new AttributeReader();
assert($reader instanceof AttributeReaderInterface);
```

The reader provides the following methods for reading PHP 8 attributes:

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

## Migrating from 1.x to 2.x

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
 }
```

The interface methods remain the same, so your existing code continues to work without changes.
