<?php

declare(strict_types=1);

namespace Koriym\Attributes\Tests\AttributeReader;

use Koriym\Attributes\AttributeReader;
use Koriym\Attributes\Tests\Fake\Annotation\FakeAbstractFoo;
use Koriym\Attributes\Tests\Fake\FakeDual;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

final class ReadingAbstractAttributeTest extends TestCase
{
    /** @var AttributeReader */
    private $attributeReader;

    /** @var ReflectionClass<FakeDual> */
    private $reflectionClass;

    /** @var ReflectionMethod */
    private $methodReflection;

    /** @var ReflectionProperty */
    private $propertyReflection;

    protected function setUp(): void
    {
        $this->attributeReader = new AttributeReader();
        $this->reflectionClass = new ReflectionClass(FakeDual::class);
        $this->methodReflection = new ReflectionMethod(FakeDual::class, 'setKey');
        $this->propertyReflection = new ReflectionProperty(FakeDual::class, 'prop');
    }

    public function testClassAttribute(): void
    {
        $classAttribute = $this->attributeReader->getClassAttribute($this->reflectionClass, FakeAbstractFoo::class);
        $this->assertInstanceOf(FakeAbstractFoo::class, $classAttribute);
    }

    public function testMethodAttribute(): void
    {
        $methodAttribute = $this->attributeReader->getMethodAttribute(
            $this->methodReflection,
            FakeAbstractFoo::class
        );
        $this->assertInstanceOf(FakeAbstractFoo::class, $methodAttribute);
    }

    public function testPropertyAttribute(): void
    {
        $propertyAttribute = $this->attributeReader->getPropertyAttribute($this->propertyReflection, FakeAbstractFoo::class);
        $this->assertInstanceOf(FakeAbstractFoo::class, $propertyAttribute);
    }
}
