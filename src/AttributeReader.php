<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Doctrine\Common\Annotations\Reader;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

/** @see \Koriym\Attributes\AttributeReaderTest */
final class AttributeReader implements Reader
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
     * @param ReflectionClass<object> $class
     * @param class-string<T>         $annotationName
     *
     * @return T|null
     *
     * @template T of object
     */
    public function getClassAnnotation(ReflectionClass $class, $annotationName): ?object
    {
        $attributes = $class->getAttributes($annotationName, ReflectionAttribute::IS_INSTANCEOF);
        if (isset($attributes[0])) {
            /** @var T $object */
            $object = $attributes[0]->newInstance();

            return $object;
        }

        return null;
    }

    /**
     * @param class-string<T> $annotationName
     *
     * @return T|null
     *
     * @template T of object
     */
    public function getMethodAnnotation(ReflectionMethod $method, $annotationName): ?object
    {
        $attributes = $method->getAttributes($annotationName, ReflectionAttribute::IS_INSTANCEOF);
        if (isset($attributes[0])) {
            /** @var T $object */
            $object = $attributes[0]->newInstance();

            return $object;
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
     * @param class-string<T> $annotationName
     *
     * @return T|null
     *
     * @template T of object
     */
    public function getPropertyAnnotation(ReflectionProperty $property, $annotationName): ?object
    {
        $attributes = $property->getAttributes($annotationName, ReflectionAttribute::IS_INSTANCEOF);
        if (isset($attributes[0])) {
            return $attributes[0]->newInstance();
        }

        return null;
    }
}
