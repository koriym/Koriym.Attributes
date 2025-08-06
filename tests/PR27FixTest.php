<?php

declare(strict_types=1);

namespace Koriym\Attributes\Tests;

use Doctrine\Common\Annotations\AnnotationReader;
use Koriym\Attributes\AttributeReader;
use Koriym\Attributes\DualReader;
use Koriym\Attributes\Tests\Fake\FakeMultipleParametersClass;
use Koriym\Attributes\Tests\Fake\FakeOpenAPIParameter;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

use function microtime;

/**
 * Test for PR #27 fix: Early return optimization to avoid array_unique issues
 *
 * @see https://github.com/koriym/Koriym.Attributes/pull/27
 */
final class PR27FixTest extends TestCase
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
    public function testEarlyReturnOptimizationForMethods(): void
    {
        $method = new ReflectionMethod(FakeMultipleParametersClass::class, 'fourParameters');
        $attributes = $this->dualReader->getMethodAnnotations($method);

        // Should work without any errors, returning exactly 4 attributes
        $this->assertCount(4, $attributes);
        $this->assertContainsOnlyInstancesOf(FakeOpenAPIParameter::class, $attributes);
    }

    /** @requires PHP >= 8.0 */
    public function testEarlyReturnOptimizationForClasses(): void
    {
        $class = new ReflectionClass(FakeMultipleParametersClass::class);
        $attributes = $this->dualReader->getClassAnnotations($class);

        // Should work without errors even if class has no annotations
        $this->assertIsArray($attributes);
    }

    /** @requires PHP >= 8.0 */
    public function testEarlyReturnOptimizationForProperties(): void
    {
        // Create a test class with attributes on properties
        $testClass = new class {
            #[FakeOpenAPIParameter(name: 'test')]
            public string $testProperty;
        };

        $property = new ReflectionProperty($testClass::class, 'testProperty');
        $attributes = $this->dualReader->getPropertyAnnotations($property);

        // Should work without errors
        $this->assertIsArray($attributes);
    }

    /** @requires PHP >= 8.0 */
    public function testPerformanceWithManyAttributes(): void
    {
        $method = new ReflectionMethod(FakeMultipleParametersClass::class, 'fiveParameters');

        $startTime = microtime(true);
        $attributes = $this->dualReader->getMethodAnnotations($method);
        $executionTime = microtime(true) - $startTime;

        // Should complete quickly (less than 10ms) thanks to early return optimization
        $this->assertLessThan(0.01, $executionTime, 'Early return optimization should make this very fast');
        $this->assertCount(5, $attributes);
    }

    /** @requires PHP >= 8.0 */
    public function testOriginalFunctionalityStillWorks(): void
    {
        // Test that when both annotations and attributes exist, they are still merged
        $method = new ReflectionMethod(FakeMultipleParametersClass::class, 'threeParameters');
        $attributes = $this->dualReader->getMethodAnnotations($method);

        // Should still work correctly for the original dual reading functionality
        $this->assertIsArray($attributes);
        $this->assertCount(3, $attributes);
    }
}
