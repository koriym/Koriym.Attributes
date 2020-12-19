<?php

namespace Koriym\Attributes\Annotation;

use Attribute;

/**
 * @Annotation
 */
#[Attribute]
final class HttpCache
{
    public bool $isPrivate;
    public int $maxAg;
    public function __construct(
        array $values = [],
        bool $isPrivate = false,
        int $maxAge = 0)
    {
        $this->isPrivate = $values['isPrivate'] ?? $isPrivate;
        $this->maxAge = $values['maxAge'] ?? $maxAge;
    }
}

