<?php

declare(strict_types=1);

namespace Koriym\Attributes\Tests\Fake;

// Test class with attributes only (no doctrine annotations)
#[SampleAttribute('class-level')]
class TestClassWithAttributes
{
    /** @var string */
    #[SampleAttribute('property-level')]
    public $testProperty;

    #[SampleAttribute('method-level')]
    public function testMethod(): void
    {
    }
}
