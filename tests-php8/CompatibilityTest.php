<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Doctrine\Common\Annotations\Reader;
use Koriym\Attributes\Annotation\FakeCacheable;
use Koriym\Attributes\Annotation\FakeFooClass;
use Koriym\Attributes\Annotation\FakeNotExists;
use Koriym\Attributes\Annotation\FakeFooInterface;
use Koriym\Attributes\Annotation\FakeHttpCache;
use Koriym\Attributes\Annotation\FakeInject;
use Koriym\Attributes\Annotation\FakeLoggable;
use Koriym\Attributes\Annotation\FakeTransactional;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

use function array_map;
use function assert;
use function class_exists;
use function get_class;

class CompatibilityTest extends TestCase
{
    /** @var class-string */
    protected $target = Fake::class;

    /** @var Reader */
    protected $attributeReader;

    protected function setUp(): void
    {
        $this->attributeReader = new AttributeReader();
    }

    public function testIsInstanceOfAttributes(): void
    {
        $actual = $this->attributeReader;
        $this->assertInstanceOf(AttributeReader::class, $actual);
    }

    public function testGetClassAnnotation(): void
    {
        $reflectionClass = new ReflectionClass($this->target);
        $annotationName = FakeCacheable::class;
        assert(class_exists($annotationName));
        $cacheable = $this->attributeReader->getClassAnnotation($reflectionClass, $annotationName);
        $this->assertInstanceOf(FakeCacheable::class, $cacheable);
        $this->assertNull($this->attributeReader->getClassAnnotation($reflectionClass, FakeNotExists::class));
    }

    public function testGetClassAnnotations(): void
    {
        $reflectionClass = new ReflectionClass($this->target);
        $attributes = $this->attributeReader->getClassAnnotations($reflectionClass);
        $actual = array_map(static function (object $attribute): string {
            return get_class($attribute);
        }, $attributes);

        $expected = [FakeFooClass::class, FakeCacheable::class];
        $this->assertEqualsCanonicalizing($expected, $actual);
    }

    public function testGetClassAnnotationNotFound(): void
    {
        $reflectionClass = new ReflectionClass($this->target);

        $this->assertNull($this->attributeReader->getClassAnnotation($reflectionClass, FakeNotExists::class));
    }

    public function testGetMethodAnnotation(): void
    {
        $reflectionMethod = new ReflectionMethod($this->target, 'subscribe');
        $annotationName = FakeHttpCache::class;
        assert(class_exists($annotationName));
        $cacheable = $this->attributeReader->getMethodAnnotation($reflectionMethod, $annotationName);

        $this->assertInstanceOf($annotationName, $cacheable);
        $this->assertNull($this->attributeReader->getMethodAnnotation($reflectionMethod, FakeNotExists::class));
    }

    public function testGetMethodAnnotations(): void
    {
        $reflectionMethod = new ReflectionMethod($this->target, 'subscribe');
        $attributes = $this->attributeReader->getMethodAnnotations($reflectionMethod);
        $actual = array_map(static function (object $attribute): string {
            return get_class($attribute);
        }, $attributes);

        $expected = [FakeLoggable::class, FakeHttpCache::class, FakeTransactional::class];
        $this->assertEqualsCanonicalizing($expected, $actual);
    }

    public function testGetMethodAnnotationNotFound(): void
    {
        $reflectionMethod = new ReflectionMethod($this->target, 'subscribe');
        $this->assertNull($this->attributeReader->getMethodAnnotation($reflectionMethod, FakeNotExists::class));
    }

    public function testGetPropertyAnnotation(): void
    {
        $reflectionProperty = new ReflectionProperty($this->target, 'prop');
        $annotationName = FakeInject::class;
        assert(class_exists($annotationName));
        $cacheable = $this->attributeReader->getPropertyAnnotation($reflectionProperty, $annotationName);
        $this->assertInstanceOf($annotationName, $cacheable);
        $this->assertNull($this->attributeReader->getPropertyAnnotation($reflectionProperty, FakeNotExists::class));
    }

    public function testGetPropertyAnnotations(): void
    {
        $reflectionProperty = new ReflectionProperty($this->target, 'prop');
        $propertyAttributes = $this->attributeReader->getPropertyAnnotations($reflectionProperty);
        $actual = array_map(static function (object $attribute): string {
            return get_class($attribute);
        }, $propertyAttributes);

        $expected = [FakeInject::class, FakeFooClass::class];
        $this->assertEqualsCanonicalizing($expected, $actual);
    }

    public function testGetPropertyAnnotationNotFound(): void
    {
        $reflectionProperty = new ReflectionProperty($this->target, 'prop');
        $this->assertNull($this->attributeReader->getPropertyAnnotation($reflectionProperty, FakeNotExists::class));
    }

    public function testReadIneterfaceInClass(): void
    {
        $reflectionClass = new ReflectionClass(FakeInterfaceRead::class);
        $classAnnotation = $this->attributeReader->getClassAnnotation($reflectionClass, FakeFooInterface::class);
        $this->assertInstanceOf(FakeFooClass::class, $classAnnotation);
    }

    public function testReadIneterfaceInMethod(): void
    {
        $reflectionMethod = new ReflectionMethod(FakeInterfaceRead::class, 'subscribe');
        $methodAnnotation = $this->attributeReader->getMethodAnnotation($reflectionMethod, FakeFooInterface::class);
        $this->assertInstanceOf(FakeFooClass::class, $methodAnnotation);

        $noAttributeMethodReflection = new ReflectionMethod(FakeInterfaceRead::class, 'noAttribute');
        $this->assertNull($this->attributeReader->getMethodAnnotation($noAttributeMethodReflection, FakeFooInterface::class));
    }

    public function testReadIneterfaceInProperty(): void
    {
        $reflectionProperty = new ReflectionProperty(FakeInterfaceRead::class, 'prop');
        $propertyAnnotation = $this->attributeReader->getPropertyAnnotation($reflectionProperty, FakeFooInterface::class);
        $this->assertInstanceOf(FakeFooClass::class, $propertyAnnotation);
    }
}
