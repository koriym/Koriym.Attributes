<?php

declare(strict_types=1);

namespace Koriym\Attributes\Tests;

use Doctrine\Common\Annotations\AnnotationReader;
use Koriym\Attributes\AttributeReader;
use Koriym\Attributes\DualReader;
use Koriym\Attributes\Tests\Fake\Annotation\FakeFooClass;
use Koriym\Attributes\Tests\Fake\Annotation\FakeInject;
use Koriym\Attributes\Tests\Fake\Annotation\FakeNotExists;
use Koriym\Attributes\Tests\Fake\FakeDual;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

final class DualReaderTest extends TestCase
{
    /** @var DualReader */
    private $dualReader;

    /** @var ReflectionClass<FakeDual> */
    private $reflectionClass;

    /** @var ReflectionMethod */
    private $reflectionMethod;

    /** @var ReflectionProperty */
    private $reflectionProperty;

    protected function setUp(): void
    {
        $this->dualReader = new DualReader(
            new AnnotationReader(),
            new AttributeReader()
        );

        $this->reflectionClass = new ReflectionClass(FakeDual::class);
        $this->reflectionMethod = new ReflectionMethod(FakeDual::class, 'setKey');
        $this->reflectionProperty = new ReflectionProperty(FakeDual::class, 'prop');
    }

    /**
     * @requires PHP < 8.0
     */
    public function testLoadOnlyAnnotations(): void
    {
        $classAnnotations = $this->dualReader->getClassAnnotations($this->reflectionClass);
        $this->assertCount(2, $classAnnotations);

        $methodAnnotations = $this->dualReader->getMethodAnnotations($this->reflectionMethod);
        $this->assertCount(1, $methodAnnotations);

        $propertyAnnotations = $this->dualReader->getPropertyAnnotations($this->reflectionProperty);
        $this->assertCount(2, $propertyAnnotations);
    }

    /**
     * @requires PHP >= 8.0
     */
    public function testBoth(): void
    {
        $classAnnotationsAndAttributes = $this->dualReader->getClassAnnotations($this->reflectionClass);
        $this->assertCount(2, $classAnnotationsAndAttributes);

        $methodAnnotationsAndAttributes = $this->dualReader->getMethodAnnotations($this->reflectionMethod);
        $this->assertCount(2, $methodAnnotationsAndAttributes);

        $propertyAnnotations = $this->dualReader->getPropertyAnnotations($this->reflectionProperty);
        $this->assertCount(2, $propertyAnnotations);
    }

    public function testClass(): void
    {
        $foundAnnotation = $this->dualReader->getClassAnnotation($this->reflectionClass, FakeFooClass::class);
        $this->assertInstanceOf(FakeFooClass::class, $foundAnnotation);

        $missingAnnotation = $this->dualReader->getClassAnnotation($this->reflectionClass, FakeNotExists::class);
        $this->assertNull($missingAnnotation);
    }

    public function testMethod(): void
    {
        $fakeInjectAnnotation = $this->dualReader->getMethodAnnotation($this->reflectionMethod, FakeInject::class);
        $this->assertInstanceOf(FakeInject::class, $fakeInjectAnnotation);

        $missingAnnotation = $this->dualReader->getMethodAnnotation($this->reflectionMethod, FakeNotExists::class);
        $this->assertNull($missingAnnotation);
    }

    public function testProperty(): void
    {
        $fakeInjectAnnotation = $this->dualReader->getPropertyAnnotation($this->reflectionProperty, FakeInject::class);
        $this->assertInstanceOf(FakeInject::class, $fakeInjectAnnotation);

        $missingAnnotation = $this->dualReader->getPropertyAnnotation($this->reflectionProperty, FakeNotExists::class);
        $this->assertNull($missingAnnotation);
    }
}
