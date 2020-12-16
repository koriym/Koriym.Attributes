<?php

namespace Koriym\Attributes\Annotation;

use Attribute;

#[Attribute]
final class Named
{
    public function __construct(
        public string $name
    )
    {
    }
}