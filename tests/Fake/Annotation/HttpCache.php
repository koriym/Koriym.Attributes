<?php

namespace Koriym\Attributes\Annotation;

use Attribute;

/**
 * @Annotation
 */
#[Attribute]
final class HttpCache
{
    public $isPrivate;
    public $maxAg;
    public function __construct(
        $values = [],
        $isPrivate = false,
        $maxAge = 0)
    {
        $this->isPrivate = $values['isPrivate'] ?? $isPrivate;
        $this->maxAge = $values['maxAge'] ?? $maxAge;
    }
}

