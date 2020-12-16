<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Doctrine\Common\Annotations\Reader;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

final class AttributesReader implements Reader
{
    public function getMethodAnnotations(ReflectionMethod $method): void
    {
        // TODO: Implement getMethodAnnotations() method.
    }

    public function getClassAnnotations(ReflectionClass $class): void
    {
        // TODO: Implement getClassAnnotations() method.
    }

    public function getClassAnnotation(ReflectionClass $class, $annotationName): void
    {
        // TODO: Implement getClassAnnotation() method.
    }

    public function getMethodAnnotation(ReflectionMethod $method, $annotationName): void
    {
        // TODO: Implement getMethodAnnotation() method.
    }

    public function getPropertyAnnotations(ReflectionProperty $property): void
    {
        // TODO: Implement getPropertyAnnotations() method.
    }

    public function getPropertyAnnotation(ReflectionProperty $property, $annotationName): void
    {
        // TODO: Implement getPropertyAnnotation() method.
    }
}
