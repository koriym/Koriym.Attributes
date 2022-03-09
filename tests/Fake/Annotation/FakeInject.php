<?php


namespace Koriym\Attributes\Tests\Fake\Annotation;

use Attribute;
use Doctrine\Common\Annotations\NamedArgumentConstructorAnnotation;

/**
 * @Annotation
 */
#[Attribute]
final class FakeInject implements NamedArgumentConstructorAnnotation
{
    public $optional;
    public function __construct(bool $optional = false)
    {
        $this->optional = $optional;
    }
}
