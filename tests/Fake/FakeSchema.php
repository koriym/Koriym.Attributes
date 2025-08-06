<?php

declare(strict_types=1);

namespace Koriym\Attributes\Tests\Fake;

use Attribute;

#[Attribute]
final class FakeSchema
{
    public function __construct(
        public string $type = 'string'
    ) {
    }
}