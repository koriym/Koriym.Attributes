<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Doctrine\Common\Annotations\Reader;
use Koriym\Attributes\Annotation\FakeAbstractFoo;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

class AttributeReaderTest extends TestCase
{
    /** @var Reader */
    protected $reader;

    protected function setUp(): void
    {
        $this->reader = new AttributeReader();
    }

    public function testGetAbstractAnnotation(): void
    {
        $class = new ReflectionClass(Fake::class);
        $classAnnotation = $this->reader->getClassAnnotation($class, FakeAbstractFoo::class);
        $this->assertInstanceOf(FakeAbstractFoo::class, $classAnnotation);
        $method = new ReflectionMethod(Fake::class, 'setKey');
        $methodAnnotation = $this->reader->getMethodAnnotation($method, FakeAbstractFoo::class);
        $this->assertInstanceOf(FakeAbstractFoo::class, $methodAnnotation);
        $prop = new ReflectionProperty(Fake::class, 'prop');
        $propAnnotation = $this->reader->getPropertyAnnotation($prop, FakeAbstractFoo::class);
        $this->assertInstanceOf(FakeAbstractFoo::class, $propAnnotation);
    }
}