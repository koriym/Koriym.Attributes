# Koriym.Attributes

A `koriym/attributes` dual reader implemets doctrine/annotation [Reader](https://github.com/doctrine/annotations/blob/master/lib/Doctrine/Common/Annotations/Reader.php) interface
in order to read both doctrine/annotation and PHP 8 attributes.

Note:  Doctrine annotations are different by design than PHP core one. 
Not all attributes can be read by this reader (ex. parameters), and not all doctrine/annotations can be read by this reader either. (ex. nested annotations)

However, This reader help you to code forward compatible that supports both PHP 7.x annotations and 8.x attributes in certain senario.

## Installation

    composer require koriym/attributes

## Usage

Create the reader instance.

```php
$reader = new DualReader(
    new AnnotationReader(),
    new AttributesReader()
);
assert($reader instanceof Reader);
```

The reader can read boht annotations and attributes.

## Compatible Annotation

Existing doctrine annotations can be changed into annotations that work for both doctrine annotation and PHP8 attributes.

Add `#[Attribute]` attribute.

```diff
use Attribute;

+#[Attribute]
final class Foo
{
}
```

Then add constructor when annotation has properties.
Following example works with both PHP8 attribute and `doctrine/annotations` in php7+.

```diff
use Attribute;

+#[Attribute]
final class Foo
{
    public string $bar;
    public int $baz;
+    public function __construct(array $value = [], string $bar = '', int $baz = 0)
+    {
+        $this->bar = $valie['bar'] ?? $bar;
+        $this->baz = $valie['baz'] ?? $baz;
+    }
}
```

First argument `$valie` is used only by `doctrine/annotations`.
The rest of arguments(`$bar`, `$baz`) are for PHP8 attribute.
Those arguments needs default value for the case in `doctrine/annotations`.
