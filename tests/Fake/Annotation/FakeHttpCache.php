<?php

namespace Koriym\Attributes\Tests\Fake\Annotation;

use Attribute;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;

/**
 * @Annotation
 * @NamedArgumentConstructor
 */
#[Attribute]
final class FakeHttpCache
{
    public $isPrivate;
    public $maxAg;
    public function __construct($isPrivate = false, $maxAge = 0)
    {
        $this->isPrivate = $isPrivate;
        $this->maxAge = $maxAge;
    }
}

