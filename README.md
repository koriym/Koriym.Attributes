# Koriym.Attributes

[![codecov](https://codecov.io/gh/koriym/Koriym.Attributes/branch/master/graph/badge.svg?token=O1MBvJrlP6)](https://codecov.io/gh/koriym/Koriym.Attributes)
[![Type Coverage](https://shepherd.dev/github/koriym/Koriym.Attributes/coverage.svg)](https://shepherd.dev/github/koriym/Koriym.Attributes)
![Continuous Integration](https://github.com/koriym/Koriym.Attributes/workflows/Continuous%20Integration/badge.svg)
![Static Analysis](https://github.com/koriym/Koriym.Attributes/workflows/Static%20Analysis/badge.svg)
![Coding Standards](https://github.com/koriym/Koriym.Attributes/workflows/Coding%20Standards/badge.svg)

A PHP 8 attribute reader that provides a familiar interface compatible with `doctrine/annotations` Reader interface.

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

## Smooth Migration

If your codebase currently uses `Doctrine\Common\Annotations\Reader`, you can migrate smoothly:

```diff
-use Doctrine\Common\Annotations\Reader;
+use Koriym\Attributes\AttributeReaderInterface;

-public function __construct(Reader $reader)
+public function __construct(AttributeReaderInterface $reader)
{
    $this->reader = $reader;
}
```

The interface methods remain the same, so your existing code continues to work without changes.
