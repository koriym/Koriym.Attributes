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
use ReflectionParameter;
use ReflectionProperty;

use function array_map;

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

    /** @var ReflectionParameter */
    private $reflectionParameter;

    protected function setUp(): void
    {
        $this->attributeReader = new AttributeReader();

        $this->reflectionClass = new ReflectionClass(FakeDual::class);
        $this->reflectionMethod = new ReflectionMethod(FakeDual::class, 'subscribe');
        $this->reflectionProperty = new ReflectionProperty(FakeDual::class, 'prop');
        $this->reflectionParameter = new ReflectionParameter([FakeDual::class, 'subscribe'], 'id');
    }

    public function testClass(): void
    {
        $foundAttributes = $this->attributeReader->getClassAttribute($this->reflectionClass, FakeCacheable::class);
        $this->assertInstanceOf(FakeCacheable::class, $foundAttributes);
    }

    public function testClasses(): void
    {
        $foundAttributes = $this->attributeReader->getClassAttributes($this->reflectionClass);

        $foundAttributeClasses = array_map(static function (object $attribute): string {
            return $attribute::class;
        }, $foundAttributes);

        $expectedAttributeClasses = [FakeFooClass::class, FakeCacheable::class];
        $this->assertEqualsCanonicalizing($expectedAttributeClasses, $foundAttributeClasses);
    }

    public function testMethod(): void
    {
        $foundAttribute = $this->attributeReader->getMethodAttribute(
            $this->reflectionMethod,
            FakeHttpCache::class
        );
        $this->assertInstanceOf(FakeHttpCache::class, $foundAttribute);
    }

    public function testMethods(): void
    {
        $foundAttributes = $this->attributeReader->getMethodAttributes($this->reflectionMethod);

        $foundAttributeClasses = $this->resolveAttributeClasses($foundAttributes);
        $expectedAttributeClasses = [FakeLoggable::class, FakeHttpCache::class, FakeTransactional::class];

        $this->assertEqualsCanonicalizing($expectedAttributeClasses, $foundAttributeClasses);
    }

    public function testProperty(): void
    {
        $foundAttribute = $this->attributeReader->getPropertyAttribute($this->reflectionProperty, FakeInject::class);
        $this->assertInstanceOf(FakeInject::class, $foundAttribute);
    }

    public function testProperties(): void
    {
        $foundAttributes = $this->attributeReader->getPropertyAttributes($this->reflectionProperty);

        $foundAttributeClasses = $this->resolveAttributeClasses($foundAttributes);
        $expectedAttributeClasses = [FakeInject::class, FakeFooClass::class];

        $this->assertEqualsCanonicalizing($expectedAttributeClasses, $foundAttributeClasses);
    }

    public function testParameter(): void
    {
        $foundAttribute = $this->attributeReader->getParameterAttribute($this->reflectionParameter, FakeLoggable::class);
        $this->assertInstanceOf(FakeLoggable::class, $foundAttribute);
    }

    public function testParameters(): void
    {
        $foundAttributes = $this->attributeReader->getParameterAttributes($this->reflectionParameter);

        $foundAttributeClasses = $this->resolveAttributeClasses($foundAttributes);
        $expectedAttributeClasses = [FakeLoggable::class, FakeInject::class];

        $this->assertEqualsCanonicalizing($expectedAttributeClasses, $foundAttributeClasses);
    }

    public function testMissingAnnotations(): void
    {
        $this->assertNull($this->attributeReader->getClassAttribute($this->reflectionClass, FakeNotExists::class));

        $this->assertNull($this->attributeReader->getMethodAttribute(
            $this->reflectionMethod,
            FakeNotExists::class
        ));

        $this->assertNull($this->attributeReader->getPropertyAttribute($this->reflectionProperty, FakeNotExists::class));

        $this->assertNull($this->attributeReader->getParameterAttribute($this->reflectionParameter, FakeNotExists::class));
    }

    /**
     * @param object[] $foundAttributes
     *
     * @return class-string[]
     */
    private function resolveAttributeClasses(array $foundAttributes): array
    {
        return array_map(static function (object $attribute): string {
            return $attribute::class;
        }, $foundAttributes);
    }
}
