<?php

namespace Koriym\Attributes\Tests\Fake\Annotation;

use Attribute;
use Doctrine\Common\Annotations\NamedArgumentConstructorAnnotation;

/**
 * @Annotation
 */
#[Attribute]
final class FakeHttpCache implements NamedArgumentConstructorAnnotation
{
    public $isPrivate;
    public $maxAg;
    public function __construct($isPrivate = false, $maxAge = 0)
    {
        $this->isPrivate = $isPrivate;
        $this->maxAge = $maxAge;
    }
}

