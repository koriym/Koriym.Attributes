<?php

namespace Koriym\Attributes\Annotation;

use Attribute;
use Doctrine\Common\Annotations\NamedArgumentConstructorAnnotation;

/**
 * @Annotation
 */
#[Attribute]
final class FakeNamed implements NamedArgumentConstructorAnnotation
{
    public string $name;
    public function __construct(string $name = '',)
    {
        $this->name = $name;
    }
}