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

final class AttributeReaderInterfaceTest extends TestCase
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
