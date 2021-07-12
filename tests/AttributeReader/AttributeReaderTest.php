<?php

declare(strict_types=1);

namespace Koriym\Attributes\Tests\AttributeReader;

use Koriym\Attributes\AttributeReader;
use Koriym\Attributes\Tests\Fake\Annotation\FakeCacheable;
use Koriym\Attributes\Tests\Fake\Annotation\FakeFooClass;
use Koriym\Attributes\Tests\Fake\Annotation\FakeHttpCache;
use Koriym\Attributes\Tests\Fake\Annotation\FakeInject;
use Koriym\Attributes\Tests\Fake\Annotation\FakeLoggable;
use Koriym\Attributes\Tests\Fake\Annotation\FakeNotExists;
use Koriym\Attributes\Tests\Fake\Annotation\FakeTransactional;
use Koriym\Attributes\Tests\Fake\FakeDual;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

use function array_map;
use function get_class;

/**
 * @requires PHP 8.0
 */
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

    public function testClass(): void
    {
        $foundAttributes = $this->attributeReader->getClassAnnotation($this->reflectionClass, FakeCacheable::class);
        $this->assertInstanceOf(FakeCacheable::class, $foundAttributes);
    }

    public function testClasses(): void
    {
        $foundAttributes = $this->attributeReader->getClassAnnotations($this->reflectionClass);

        $foundAttributeClasses = array_map(static function (object $attribute): string {
            return get_class($attribute);
        }, $foundAttributes);

        $expectedAttributeClasses = [FakeFooClass::class, FakeCacheable::class];
        $this->assertEqualsCanonicalizing($expectedAttributeClasses, $foundAttributeClasses);
    }

    public function testMethod(): void
    {
        $foundAttribute = $this->attributeReader->getMethodAnnotation(
            $this->reflectionMethod,
            FakeHttpCache::class
        );
        $this->assertInstanceOf(FakeHttpCache::class, $foundAttribute);
    }

    public function testMethods(): void
    {
        $foundAttributes = $this->attributeReader->getMethodAnnotations($this->reflectionMethod);

        $foundAttributeClasses = $this->resolveAttributeClasses($foundAttributes);
        $expectedAttributeClasses = [FakeLoggable::class, FakeHttpCache::class, FakeTransactional::class];

        $this->assertEqualsCanonicalizing($expectedAttributeClasses, $foundAttributeClasses);
    }

    public function testProperty(): void
    {
        $foundAttribute = $this->attributeReader->getPropertyAnnotation($this->reflectionProperty, FakeInject::class);
        $this->assertInstanceOf(FakeInject::class, $foundAttribute);
    }

    public function testProperties(): void
    {
        $foundAttributes = $this->attributeReader->getPropertyAnnotations($this->reflectionProperty);

        $foundAttributeClasses = $this->resolveAttributeClasses($foundAttributes);
        $expectedAttributeClasses = [FakeInject::class, FakeFooClass::class];

        $this->assertEqualsCanonicalizing($expectedAttributeClasses, $foundAttributeClasses);
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

    /**
     * @param object[] $foundAttributes
     *
     * @return class-string[]
     */
    private function resolveAttributeClasses(array $foundAttributes): array
    {
        return array_map(static function (object $attribute): string {
            return get_class($attribute);
        }, $foundAttributes);
    }
}
