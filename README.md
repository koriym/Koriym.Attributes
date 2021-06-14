# Koriym.Attributes

[![codecov](https://codecov.io/gh/koriym/Koriym.Attributes/branch/master/graph/badge.svg?token=O1MBvJrlP6)](https://codecov.io/gh/koriym/Koriym.Attributes)
[![Type Coverage](https://shepherd.dev/github/koriym/Koriym.Attributes/coverage.svg)](https://shepherd.dev/github/koriym/Koriym.Attributes)
![Continuous Integration](https://github.com/koriym/Koriym.Attributes/workflows/Continuous%20Integration/badge.svg)
![Static Analysis](https://github.com/koriym/Koriym.Attributes/workflows/Static%20Analysis/badge.svg)
![Coding Standards](https://github.com/koriym/Koriym.Attributes/workflows/Coding%20Standards/badge.svg)

A `koriym/attributes` dual reader implements doctrine/annotation [Reader](https://github.com/doctrine/annotations/blob/master/lib/Doctrine/Common/Annotations/Reader.php) interface
in order to read both doctrine/annotation and PHP 8 attributes.

Doctrine annotations are different by design than PHP core one. 
Not all attributes can be read by this reader (ex. parameters), and not all doctrine/annotations can be read by this reader either. (ex. nested annotations)

However, This reader help you to code forward compatible that supports both PHP 7.x annotations and 8.x attributes in certain senario.

## Installation

    composer require koriym/attributes

## Usage

Create the reader instance.

```php
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use Koriym\Attributes\DualReader;
use Koriym\Attributes\AttributeReader;

$reader = new DualReader(
    new AnnotationReader(),
    new AttributeReader()
);
assert($reader instanceof Reader);
```

The reader can read both annotations and attributes.

## Compatible Annotation

Existing doctrine annotations can be changed into annotations that work for both doctrine annotation and PHP8 attributes.

Add `#[Attribute]` attribute.

```diff
use Attribute;

/** @Annotation */
+#[Attribute]
final class Foo
{
}
```

Then add constructor when annotation has properties.
Following example works with both PHP8 attribute and `doctrine/annotations`.

```diff
use Attribute;
+use Doctrine\Common\Annotations\NamedArgumentConstructor;

/**
 * @Annotation 
 * @Target("METHOD")
+* @NamedArgumentConstructor
 */
+#[Attribute(Attribute::TARGET_METHOD)]
final class Foo
{
    public string $bar;
    public int $baz;
+    public function __construct(string $bar = '', int $baz = 0)
+    {
+        $this->bar = $bar;
+        $this->baz = $baz;
+    }
}
```

See more about annotation compatible attribute at [Constructors with Named Parameters](https://github.com/doctrine/annotations/blob/1.11.x/docs/en/custom.rst#optional-constructors-with-named-parameters)
