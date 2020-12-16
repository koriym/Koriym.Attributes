<?php

namespace Koriym\Attributes\Annotation;

use Attribute;

#[Attribute]
final class HttpCache
{
    public function __construct(
        public bool $isPrivate,
        public int $maxAge
    )
    {
    }
}

