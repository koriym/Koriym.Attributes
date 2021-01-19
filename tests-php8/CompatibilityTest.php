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
    protected $reader;

    protected function setUp(): void
    {
        $this->reader = new AttributeReader();
    }

    public function testIsInstanceOfAttributes(): void
    {
        $actual = $this->reader;
        $this->assertInstanceOf(AttributeReader::class, $actual);
    }

    public function testGetClassAnnotation(): void
    {
        $class = new ReflectionClass($this->target);
        $annotationName = FakeCacheable::class;
        assert(class_exists($annotationName));
        $cacheable = $this->reader->getClassAnnotation($class, $annotationName);
        $this->assertInstanceOf(FakeCacheable::class, $cacheable);
        $this->assertNull($this->reader->getClassAnnotation($class, FakeNotExists::class));
    }

    public function testGetClassAnnotations(): void
    {
        $class = new ReflectionClass($this->target);
        $attributes = $this->reader->getClassAnnotations($class);
        $actural = array_map(static function (object $attribute): string {
            return get_class($attribute);
        }, $attributes);
        $expected = [FakeFooClass::class, FakeCacheable::class];
        $this->assertEqualsCanonicalizing($expected, $actural);
    }

    public function testGetClassAnnotationNotFound(): void
    {
        $class = new ReflectionClass($this->target);
        $this->assertNull($this->reader->getClassAnnotation($class, FakeNotExists::class));
    }

    public function testGetMethodAnnotation(): void
    {
        $method = new ReflectionMethod($this->target, 'subscribe');
        $annotationName = FakeHttpCache::class;
        assert(class_exists($annotationName));
        $cacheable = $this->reader->getMethodAnnotation($method, $annotationName);
        $this->assertInstanceOf($annotationName, $cacheable);
        $this->assertNull($this->reader->getMethodAnnotation($method, FakeNotExists::class));
    }

    public function testGetMethodAnnotations(): void
    {
        $method = new ReflectionMethod($this->target, 'subscribe');
        $attributes = $this->reader->getMethodAnnotations($method);
        $actural = array_map(static function (object $attribute): string {
            return get_class($attribute);
        }, $attributes);
        $expected = [FakeLoggable::class, FakeHttpCache::class, FakeTransactional::class];
        $this->assertEqualsCanonicalizing($expected, $actural);
    }

    public function testGetMethodAnnotationNotFound(): void
    {
        $method = new ReflectionMethod($this->target, 'subscribe');
        $this->assertNull($this->reader->getMethodAnnotation($method, FakeNotExists::class));
    }

    public function testGetPropertyAnnotation(): void
    {
        $prop = new ReflectionProperty($this->target, 'prop');
        $annotationName = FakeInject::class;
        assert(class_exists($annotationName));
        $cacheable = $this->reader->getPropertyAnnotation($prop, $annotationName);
        $this->assertInstanceOf($annotationName, $cacheable);
        $this->assertNull($this->reader->getPropertyAnnotation($prop, FakeNotExists::class));
    }

    public function testGetPropertyAnnotations(): void
    {
        $prop = new ReflectionProperty($this->target, 'prop');
        $attributes = $this->reader->getPropertyAnnotations($prop);
        $actural = array_map(static function (object $attribute): string {
            return get_class($attribute);
        }, $attributes);
        $expected = [FakeInject::class, FakeFooClass::class];
        $this->assertEqualsCanonicalizing($expected, $actural);
    }

    public function testGetPropertyAnnotationNotFound(): void
    {
        $prop = new ReflectionProperty($this->target, 'prop');
        $this->assertNull($this->reader->getPropertyAnnotation($prop, FakeNotExists::class));
    }

    public function testReadIneterfaceInClass(): void
    {
        $class = new ReflectionClass(FakeInterfaceRead::class);
        $annotation = $this->reader->getClassAnnotation($class, FakeFooInterface::class);
        $this->assertInstanceOf(FakeFooClass::class, $annotation);
    }

    public function testReadIneterfaceInMethod(): void
    {
        $method = new ReflectionMethod(FakeInterfaceRead::class, 'subscribe');
        $annotation = $this->reader->getMethodAnnotation($method, FakeFooInterface::class);
        $this->assertInstanceOf(FakeFooClass::class, $annotation);
        $noAttributeMethod = new ReflectionMethod(FakeInterfaceRead::class, 'noAttribute');
        $this->assertNull($this->reader->getMethodAnnotation($noAttributeMethod, FakeFooInterface::class));
    }

    public function testReadIneterfaceInProperty(): void
    {
        $class = new ReflectionProperty(FakeInterfaceRead::class, 'prop');
        $annotation = $this->reader->getPropertyAnnotation($class, FakeFooInterface::class);
        $this->assertInstanceOf(FakeFooClass::class, $annotation);
    }
}
