<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use ReflectionProperty;

final class AttributeReader implements AttributeReaderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getClassAttributes(ReflectionClass $class): array
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
    public function getClassAttribute(ReflectionClass $class, string $attributeName): object|null
    {
        $attributes = $class->getAttributes($attributeName, ReflectionAttribute::IS_INSTANCEOF);
        if (isset($attributes[0])) {
            return $attributes[0]->newInstance();
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getMethodAttributes(ReflectionMethod $method): array
    {
        $attributesRefs = $method->getAttributes();
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
    public function getMethodAttribute(ReflectionMethod $method, string $attributeName): object|null
    {
        $attributes = $method->getAttributes($attributeName, ReflectionAttribute::IS_INSTANCEOF);
        if (isset($attributes[0])) {
            return $attributes[0]->newInstance();
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getPropertyAttributes(ReflectionProperty $property): array
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
    public function getPropertyAttribute(ReflectionProperty $property, string $attributeName): object|null
    {
        $attributes = $property->getAttributes($attributeName, ReflectionAttribute::IS_INSTANCEOF);
        if (isset($attributes[0])) {
            return $attributes[0]->newInstance();
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getParameterAttributes(ReflectionParameter $param): array
    {
        $attributes = $param->getAttributes();
        $instances = [];
        foreach ($attributes as $attribute) {
            $instances[] = $attribute->newInstance();
        }

        return $instances;
    }

    /**
     * {@inheritDoc}
     *
     * @template T of object
     */
    public function getParameterAttribute(ReflectionParameter $param, string $attributeName): object|null
    {
        $attributes = $param->getAttributes($attributeName);
        if (isset($attributes[0])) {
            return $attributes[0]->newInstance();
        }

        return null;
    }
}
