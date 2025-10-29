<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

final class AttributeReader implements AttributeReaderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getMethodAnnotations(ReflectionMethod $method): array
    {
        $attributesRefs = $method->getAttributes();
        $attributes = [];
        foreach ($attributesRefs as $ref) {
            $attributes[] = $ref->newInstance();
        }

        return $attributes;
    }

    /**
     * @param ReflectionClass<object> $class
     *
     * @return array<object>
     */
    public function getClassAnnotations(ReflectionClass $class): array
    {
        $attributesRefs = $class->getAttributes();
        $attributes = [];
        foreach ($attributesRefs as $ref) {
            $attribute = $ref->newInstance();
            $attributes[] = $attribute;
        }

        return $attributes;
    }

    /**
     * {@inheritDoc}
     *
     * @template T of object
     */
    public function getClassAnnotation(ReflectionClass $class, string $annotationName): object|null
    {
        $attributes = $class->getAttributes($annotationName, ReflectionAttribute::IS_INSTANCEOF);
        if (isset($attributes[0])) {
            return $attributes[0]->newInstance();
        }

        return null;
    }

    /**
     * {@inheritDoc}
     *
     * @template T of object
     */
    public function getMethodAnnotation(ReflectionMethod $method, string $annotationName): object|null
    {
        $attributes = $method->getAttributes($annotationName, ReflectionAttribute::IS_INSTANCEOF);
        if (isset($attributes[0])) {
            return $attributes[0]->newInstance();
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getPropertyAnnotations(ReflectionProperty $property): array
    {
        $attributesRefs = $property->getAttributes();
        $attributes = [];
        foreach ($attributesRefs as $ref) {
            $attributes[] = $ref->newInstance();
        }

        return $attributes;
    }

    /**
     * {@inheritDoc}
     *
     * @template T of object
     */
    public function getPropertyAnnotation(ReflectionProperty $property, string $annotationName): object|null
    {
        $attributes = $property->getAttributes($annotationName, ReflectionAttribute::IS_INSTANCEOF);
        if (isset($attributes[0])) {
            return $attributes[0]->newInstance();
        }

        return null;
    }
}
