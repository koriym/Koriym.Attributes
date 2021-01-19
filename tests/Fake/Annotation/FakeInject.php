<?php


namespace Koriym\Attributes\Annotation;

use Attribute;

/**
 * @Annotation
 */
#[Attribute]
final class FakeInject
{
    public $optional;
    public function __construct(
        array $values = [],
        bool $optional = false
    )
    {
        $this->optional = $values['optional'] ?? $optional;
    }
}