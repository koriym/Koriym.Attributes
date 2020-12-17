<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Inherit all test of AttributeReaferTest
 */
class DualReaderTest extends AttributeReaferTest
{
    protected function setUp(): void
    {
        $this->reader = new DualReader(
            new AnnotationReader(),
            new AttributesReader()
        );
    }

    public function testIsInstanceOfAttributes(): void
    {
        $actual = $this->reader;
        $this->assertInstanceOf(DualReader::class, $actual);
    }
}
