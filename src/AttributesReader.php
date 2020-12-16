<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Doctrine\Common\Annotations\Reader;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

use function assert;
use function is_string;

final class AttributesReader implements Reader
{
    /**
     * {@inheritDoc}
     */
    public function getMethodAnnotations(ReflectionMethod $method): array
    {
        $attributesRefs = $method->getAttributes();
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

    /**
     * {@inheritDoc}
     */
    public function getMethodAnnotation(ReflectionMethod $method, $annotationName): ?object
    {
        $attribute = $method->getAttributes($annotationName);

        return isset($attribute[0]) ? $attribute[0]->newInstance() : null;
    }

    /**
     * {@inheritDoc}
     */
    public function getPropertyAnnotations(ReflectionProperty $property): array
    {
        $attributesRefs = $property->getAttributes();
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
    public function getPropertyAnnotation(ReflectionProperty $property, $annotationName): ?object
    {
        assert(is_string($annotationName));
        $attribute = $property->getAttributes($annotationName);

        return isset($attribute[0]) ? $attribute[0]->newInstance() : null;
    }
}
