<?php

declare(strict_types=1);

namespace Koriym\Attributes\Tests;

use Doctrine\Common\Annotations\AnnotationReader;
use Koriym\Attributes\AttributeReader;
use Koriym\Attributes\DualReader;
use Koriym\Attributes\Tests\Fake\FakeMultipleParametersClass;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

/**
 * Test for Issue #26: "Nesting level too deep - recursive dependency?"
 *
 * @see https://github.com/koriym/Koriym.Attributes/issues/26
 */
final class Issue26Test extends TestCase
{
    private DualReader $dualReader;

    protected function setUp(): void
    {
        $this->dualReader = new DualReader(
            new AnnotationReader(),
            new AttributeReader()
        );
    }

    /** @requires PHP >= 8.0 */
    public function testThreeParametersWorksFine(): void
    {
        $method = new ReflectionMethod(FakeMultipleParametersClass::class, 'threeParameters');
        $attributes = $this->dualReader->getMethodAnnotations($method);

        $this->assertCount(3, $attributes);
    }

    /**
     * @requires PHP >= 8.0
     * This test should FAIL with current implementation due to SORT_REGULAR causing recursive dependency
     */
    public function testFourParametersCausesRecursiveError(): void
    {
        $method = new ReflectionMethod(FakeMultipleParametersClass::class, 'fourParameters');

        // This should trigger "Nesting level too deep - recursive dependency?" error
        $attributes = $this->dualReader->getMethodAnnotations($method);

        $this->assertCount(4, $attributes);
    }

    /**
     * @requires PHP >= 8.0
     * This test should also FAIL with current implementation
     */
    public function testFiveParametersCausesRecursiveError(): void
    {
        $method = new ReflectionMethod(FakeMultipleParametersClass::class, 'fiveParameters');

        // This should trigger "Nesting level too deep - recursive dependency?" error
        $attributes = $this->dualReader->getMethodAnnotations($method);

        $this->assertCount(5, $attributes);
    }
}
