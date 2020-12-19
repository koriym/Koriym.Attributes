<?php


namespace Koriym\Attributes\Annotation;

use Attribute;

/**
 * @Annotation
 */
#[Attribute]
final class Inject
{
    public bool $optional;
    public function __construct(
        array $values = [],
        bool $optional = false
    )
    {
        $this->optional = $values['optional'] ?? $optional;
    }
}