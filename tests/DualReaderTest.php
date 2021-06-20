<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Inherit all test of AttributeReaderTest
 */
class DualReaderTest extends CompatibilityTest
{
    /** @var class-string */
    protected $target = FakeDual::class;

    protected function setUp(): void
    {
        $this->reader = new DualReader(
            new AnnotationReader(),
            new AttributeReader()
        );
    }

    public function testIsInstanceOfAttributes(): void
    {
        $actual = $this->reader;
        $this->assertInstanceOf(DualReader::class, $actual);
    }
}
