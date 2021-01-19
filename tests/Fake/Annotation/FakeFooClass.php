<?php


namespace Koriym\Attributes\Annotation;

use Attribute;

/**
 * @Annotation
 */
#[Attribute]
final class FakeFooClass extends FakeAbstractFoo implements FakeFooInterface
{
}
