<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Koriym\Attributes\Annotation\Cacheable;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

use function assert;
use function class_exists;

class AttributesTest extends TestCase
{
    protected AttributesReader $reader;

    protected function setUp(): void
    {
        $this->reader = new AttributesReader();
    }

    public function testIsInstanceOfAttributes(): void
    {
        $actual = $this->reader;
        $this->assertInstanceOf(AttributesReader::class, $actual);
    }

    public function testGetClassAnnotation(): void
    {
        $class = new ReflectionClass(Fake::class);
        $annotationName = Cacheable::class;
        assert(class_exists($annotationName));
        $cacheable = $this->reader->getClassAnnotation($class, $annotationName);
        $this->assertInstanceOf(Cacheable::class, $cacheable);
    }
}
