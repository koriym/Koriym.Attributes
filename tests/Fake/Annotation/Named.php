<?php

namespace Koriym\Attributes\Annotation;

use Attribute;

/**
 * @Annotation
 */
#[Attribute]
final class Named
{
    public string $name;
    public function __construct(
        array $values = [],
        string $name = '',
    )
    {
        $this->name = $values['name'] ?? $name;
    }
}