<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Doctrine\Common\Annotations\Reader;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

use function interface_exists;
use function is_subclass_of;

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
     * @psalm-param ReflectionClass $class
     * @phpstan-param ReflectionClass<object> $class
     *
     * @return array<object>
     *
     * @template T of object
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
     * @param class-string<T> $annotationName
     * @psalm-param ReflectionClass $class
     * @phpstan-param ReflectionClass<object> $class
     *
     * @psalm-return object|null
     * @phpstan-return T
     *
     * @template T of object
     * @psalm-suppress ImplementedReturnTypeMismatch
     */
    public function getClassAnnotation(ReflectionClass $class, $annotationName): ?object
    {
        $attributes = $class->getAttributes($annotationName);
        if (isset($attributes[0])) {
            /** @var T $object */
            $object = $attributes[0]->newInstance();

            return $object;
        }

        if (interface_exists($annotationName)) {
            return $this->seekInterface($class->getAttributes(), $annotationName);
        }

        return null;
    }

    /**
     * {@inheritDoc}
     *
     * @param class-string<T> $annotationName
     *
     * @return T
     *
     * @template T of object
     */
    public function getMethodAnnotation(ReflectionMethod $method, $annotationName): ?object
    {
        $attributes = $method->getAttributes($annotationName);
        if (isset($attributes[0])) {
            /** @var T $object */
            $object = $attributes[0]->newInstance();

            return $object;
        }

        if (interface_exists($annotationName)) {
            return $this->seekInterface($method->getAttributes(), $annotationName);
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
     * @param class-string<T> $annotationName
     *
     * @return T|null
     *
     * @template T of object
     */
    public function getPropertyAnnotation(ReflectionProperty $property, $annotationName): ?object
    {
        $attributes = $property->getAttributes($annotationName);
        if (isset($attributes[0])) {
            /** @var T $object */
            $object = $attributes[0]->newInstance();

            return $object;
        }

        if (interface_exists($annotationName)) {
            return $this->seekInterface($property->getAttributes(), $annotationName);
        }

        return null;
    }

    /**
     * @param array<ReflectionAttribute> $attributes
     * @param class-string<T>            $interface
     *
     * @return T|null
     *
     * @template T of object
     */
    private function seekInterface(array $attributes, string $interface): ?object
    {
        foreach ($attributes as $attribute) {
            if (is_subclass_of($attribute->getName(), $interface)) {
                /** @var T $object */
                $object =  $attribute->newInstance();

                return $object;
            }
        }

        return null;
    }
}
