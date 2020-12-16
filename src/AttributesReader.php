<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Doctrine\Common\Annotations\Reader;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

final class AttributesReader implements Reader
{
    public function getMethodAnnotations(ReflectionMethod $method): void
    {
        // TODO: Implement getMethodAnnotations() method.
    }

    /**
     * {@inheritDoc}
     */
    public function getClassAnnotations(ReflectionClass $class): array
    {
        $attributesRefs = $class->getAttributes();
        $attributes = [];
        foreach ($attributesRefs as $ref) {
            if ($ref instanceof ReflectionAttribute) {
                $attributes[] = $ref->newInstance();
            }
        }

        return $attributes;
    }

    /**
     * {@inheritDoc}
     */
    public function getClassAnnotation(ReflectionClass $class, $annotationName): ?object
    {
        $attribute = $class->getAttributes($annotationName);

        return isset($attribute[0]) ? $attribute[0]->newInstance() : null;
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
