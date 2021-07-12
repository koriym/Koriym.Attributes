<?php

declare(strict_types=1);

namespace Koriym\Attributes\Tests\AttributeReader;

use Koriym\Attributes\AttributeReader;
use Koriym\Attributes\Tests\Fake\Annotation\FakeFooClass;
use Koriym\Attributes\Tests\Fake\Annotation\FakeFooInterface;
use Koriym\Attributes\Tests\Fake\FakeInterfaceRead;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

/**
 * @requires PHP >= 8.0
 */
final class ReadingInterfaceTest extends TestCase
{
    /** @var AttributeReader */
    private $attributeReader;

    /** @var ReflectionClass<FakeInterfaceRead> */
    private $reflectionClass;

    /** @var ReflectionMethod */
    private $reflectionMethod;

    /** @var ReflectionProperty */
    private $reflectionProperty;

    protected function setUp(): void
    {
        $this->attributeReader = new AttributeReader();

        $this->reflectionClass = new ReflectionClass(FakeInterfaceRead::class);
        $this->reflectionProperty = new ReflectionProperty(FakeInterfaceRead::class, 'prop');
        $this->reflectionMethod = new ReflectionMethod(FakeInterfaceRead::class, 'subscribe');
    }

    public function testClassAttribute(): void
    {
        $classAttribute = $this->attributeReader->getClassAnnotation($this->reflectionClass, FakeFooInterface::class);
        $this->assertInstanceOf(FakeFooClass::class, $classAttribute);
    }

    public function testReadIneterfaceInMethod(): void
    {
        $methodAttribute = $this->attributeReader->getMethodAnnotation($this->reflectionMethod, FakeFooInterface::class);
        $this->assertInstanceOf(FakeFooClass::class, $methodAttribute);
    }

    public function testPropertyAttribute(): void
    {
        $propertyAttribute = $this->attributeReader->getPropertyAnnotation($this->reflectionProperty, FakeFooInterface::class);
        $this->assertInstanceOf(FakeFooClass::class, $propertyAttribute);
    }
}
