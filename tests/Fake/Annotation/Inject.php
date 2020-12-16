<?php


namespace Koriym\Attributes\Annotation;

use Attribute;

#[Attribute]
final class Inject
{
    public function __construct(
        public bool $optional = false
    )
    {
    }
}