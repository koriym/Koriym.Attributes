<?php

declare(strict_types=1);

namespace Koriym\Attributes\Tests\Fake;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
final class FakeOpenAPIParameter
{
    public function __construct(
        public string $name,
        public string $in = 'query',
        public bool $required = false,
        public ?FakeSchema $schema = null
    ) {
        $this->schema = $schema ?? new FakeSchema('string');
    }
}