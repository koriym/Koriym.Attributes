<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Koriym\Attributes\Annotation\Cacheable;
use Koriym\Attributes\Annotation\PaidMemberOnly;
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

    public function testGetClassAnnotationItem(): void
    {
        $class = new ReflectionClass(Fake::class);
        $annotationName = Cacheable::class;
        assert(class_exists($annotationName));
        $cacheable = $this->reader->getClassAnnotation($class, $annotationName);
        $this->assertInstanceOf(Cacheable::class, $cacheable);
    }

    public function testGetClassAnnotationList(): void
    {
        $class = new ReflectionClass(Fake::class);
        $attributes = $this->reader->getClassAnnotations($class);
        $expected = [new PaidMemberOnly(), new Cacheable()];
        $this->assertEqualsCanonicalizing($expected, $attributes);
    }
}
