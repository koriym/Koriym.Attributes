# Koriym.Attributes

A `koriym/attributes` dual reader implemets doctrine/annotation [Reader](https://github.com/doctrine/annotations/blob/master/lib/Doctrine/Common/Annotations/Reader.php) interface
in order to read both doctrine/annotation and PHP 8 attributes.

Note:  Doctrine annotations are different by design than PHP core one. 
Not all attributes can be read by this reader (ex. parameters), and not all doctrine/annotations can be read by this reader either. (ex. nested annotations)

However, This reader help you to code forward compatible that supports both PHP 7.x annotations and 8.x attributes in certain senario.

## Installation

    composer require koriym/attributes

## Compatible Annotation

Add `#[Attribute]` attribute to exsiting doctrine annotation.
This annotation can be instantiated by PHP8 attribute or `doctrine/annotations` in php7+.

```php
use Attribute;
#[Attribute]
final class Foo
{
}
```

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
