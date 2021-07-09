<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Koriym\Attributes\Annotation\FakeCacheable;
use Koriym\Attributes\Annotation\FakeFooClass;
use Koriym\Attributes\Annotation\FakeFooInterface;
use Koriym\Attributes\Annotation\FakeHttpCache;
use Koriym\Attributes\Annotation\FakeInject;
use Koriym\Attributes\Annotation\FakeLoggable;
use Koriym\Attributes\Annotation\FakeNotExists;
use Koriym\Attributes\Annotation\FakeTransactional;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

use function array_map;
use function get_class;

final class AttributeReaderTest extends TestCase
{
    /** @var AttributeReader */
    private $attributeReader;

    /** @var ReflectionClass<FakeDual> */
    private $reflectionClass;

    /** @var ReflectionMethod */
    private $reflectionMethod;

    /** @var ReflectionProperty */
    private $reflectionProperty;

    protected function setUp(): void
    {
        $this->attributeReader = new AttributeReader();

        $this->reflectionClass = new ReflectionClass(FakeDual::class);
        $this->reflectionMethod = new ReflectionMethod(FakeDual::class, 'subscribe');
        $this->reflectionProperty = new ReflectionProperty(FakeDual::class, 'prop');
    }

    public function testGetClassAnnotation(): void
    {
        $annotationName = FakeCacheable::class;
        $cacheable = $this->attributeReader->getClassAnnotation($this->reflectionClass, $annotationName);

        $this->assertInstanceOf(FakeCacheable::class, $cacheable);

        $missingClassAnnotation = $this->attributeReader->getClassAnnotation($this->reflectionClass, FakeNotExists::class);
        $this->assertNull($missingClassAnnotation);
    }

    public function testGetClassAnnotations(): void
    {
        $attributes = $this->attributeReader->getClassAnnotations($this->reflectionClass);
        $actual = array_map(static function (object $attribute): string {
            return get_class($attribute);
        }, $attributes);

        $expected = [FakeFooClass::class, FakeCacheable::class];
        $this->assertEqualsCanonicalizing($expected, $actual);
    }

    public function testGetMethodAnnotation(): void
    {
        $fakeHttpCacheAnnotation = $this->attributeReader->getMethodAnnotation(
            $this->reflectionMethod,
            FakeHttpCache::class
        );

        $this->assertInstanceOf(FakeHttpCache::class, $fakeHttpCacheAnnotation);
    }

    public function testMissingAnnotations(): void
    {
        $this->assertNull($this->attributeReader->getClassAnnotation($this->reflectionClass, FakeNotExists::class));

        $this->assertNull($this->attributeReader->getMethodAnnotation(
            $this->reflectionMethod,
            FakeNotExists::class
        ));

        $this->assertNull($this->attributeReader->getPropertyAnnotation($this->reflectionProperty, FakeNotExists::class));
    }

    public function testGetMethodAnnotations(): void
    {
        $reflectionMethod = new ReflectionMethod(FakeDual::class, 'subscribe');
        $attributes = $this->attributeReader->getMethodAnnotations($reflectionMethod);
        $actual = array_map(static function (object $attribute): string {
            return get_class($attribute);
        }, $attributes);

        $expected = [FakeLoggable::class, FakeHttpCache::class, FakeTransactional::class];
        $this->assertEqualsCanonicalizing($expected, $actual);
    }

    public function testGetPropertyAnnotation(): void
    {
        $foundAnnotation = $this->attributeReader->getPropertyAnnotation($this->reflectionProperty, FakeInject::class);
        $this->assertInstanceOf(FakeInject::class, $foundAnnotation);
    }

    public function testGetPropertyAnnotations(): void
    {
        $propertyAttributes = $this->attributeReader->getPropertyAnnotations($this->reflectionProperty);
        $actual = array_map(static function (object $attribute): string {
            return get_class($attribute);
        }, $propertyAttributes);

        $expected = [FakeInject::class, FakeFooClass::class];
        $this->assertEqualsCanonicalizing($expected, $actual);
    }
}
