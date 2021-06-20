<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Cache\Adapter\PHPArray\ArrayCachePool;
use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Inherit all test of AttributeReaderTest
 */
class CachedReaderTest extends CompatibilityTest
{
    /** @var class-string */
    protected $target = FakeDual::class;

    protected function setUp(): void
    {
        $this->reader = new CachedReader(
            new AnnotationReader(),
            new ArrayCachePool()
        );
    }

    public function testIsInstanceOfAttributes(): void
    {
        $actual = $this->reader;
        $this->assertInstanceOf(CachedReader::class, $actual);
    }
}
