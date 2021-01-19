<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Doctrine\Common\Annotations\Reader;
use Koriym\Attributes\Annotation\AbstractFoo;
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
        $classAnnotation = $this->reader->getClassAnnotation($class, AbstractFoo::class);
        $this->assertInstanceOf(AbstractFoo::class, $classAnnotation);
        $method = new ReflectionMethod(Fake::class, 'setKey');
        $methodAnnotation = $this->reader->getMethodAnnotation($method, AbstractFoo::class);
        $this->assertInstanceOf(AbstractFoo::class, $methodAnnotation);
        $prop = new ReflectionProperty(Fake::class, 'prop');
        $propAnnotation = $this->reader->getPropertyAnnotation($prop, AbstractFoo::class);
        $this->assertInstanceOf(AbstractFoo::class, $propAnnotation);
    }
}