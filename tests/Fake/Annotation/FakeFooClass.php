<?php


namespace Koriym\Attributes\Tests\Fake\Annotation;

use Attribute;

/**
 * @Annotation
 */
#[Attribute]
final class FakeFooClass extends FakeAbstractFoo implements FakeFooInterface
{
}
