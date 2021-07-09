<?php

declare(strict_types=1);

namespace Koriym\Attributes\Tests;

use Doctrine\Common\Annotations\AnnotationReader;
use Koriym\Attributes\AttributeReader;
use Koriym\Attributes\DualReader;
use Koriym\Attributes\Tests\Fake\FakeDual;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;

final class DualReaderTest extends TestCase
{
    /** @var DualReader */
    private $dualReader;

    /** @var ReflectionClass<FakeDual> */
    private $fakeDualReflectionClass;

    /** @var ReflectionMethod */
    private $fakeDualReflectionMethod;

    protected function setUp(): void
    {
        $this->dualReader = new DualReader(
            new AnnotationReader(),
            new AttributeReader()
        );

        $this->fakeDualReflectionClass = new ReflectionClass(FakeDual::class);
        $this->fakeDualReflectionMethod = new ReflectionMethod(FakeDual::class, 'setKey');
    }

    /**
     * @requires PHP < 8.0
     */
    public function testLoadOnlyAnnotations(): void
    {
        $classAnnotations = $this->dualReader->getClassAnnotations($this->fakeDualReflectionClass);
        $this->assertCount(2, $classAnnotations);

        $methodAnnotationsAndAttributes = $this->dualReader->getMethodAnnotations($this->fakeDualReflectionMethod);
        $this->assertCount(1, $methodAnnotationsAndAttributes);
    }

    /**
     * @requires PHP >= 8.0
     */
    public function testBoth(): void
    {
        $classAnnotationsAndAttributes = $this->dualReader->getClassAnnotations($this->fakeDualReflectionClass);
        $this->assertCount(4, $classAnnotationsAndAttributes);

        $methodAnnotationsAndAttributes = $this->dualReader->getMethodAnnotations($this->fakeDualReflectionMethod);
        $this->assertCount(3, $methodAnnotationsAndAttributes);
    }
}
