<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use ReflectionProperty;

interface AttributeReaderInterface
{
    /**
     * Gets the attributes applied to a class.
     *
     * @param ReflectionClass<object> $class
     *
     * @return array<object>
     */
    public function getClassAttributes(ReflectionClass $class): array;

    /**
     * Gets a class attribute.
     *
     * @param ReflectionClass<object> $class
     * @param class-string<T>         $attributeName
     *
     * @return T|null
     *
     * @template T of object
     */
    public function getClassAttribute(ReflectionClass $class, string $attributeName): object|null;

    /**
     * Gets the attributes applied to a method.
     *
     * @return array<object>
     */
    public function getMethodAttributes(ReflectionMethod $method): array;

    /**
     * Gets a method attribute.
     *
     * @param class-string<T> $attributeName
     *
     * @return T|null
     *
     * @template T of object
     */
    public function getMethodAttribute(ReflectionMethod $method, string $attributeName): object|null;

    /**
     * Gets the attributes applied to a property.
     *
     * @return array<object>
     */
    public function getPropertyAttributes(ReflectionProperty $property): array;

    /**
     * Gets a property attribute.
     *
     * @param class-string<T> $attributeName
     *
     * @return T|null
     *
     * @template T of object
     */
    public function getPropertyAttribute(ReflectionProperty $property, string $attributeName): object|null;

    /**
     * Gets the attributes applied to a method parameter.
     *
     * @param ReflectionParameter $param The ReflectionParameter of the parameter
     *                                   from which the attributes should be read.
     *
     * @return array<object> An array of Annotations/Attributes.
     */
    public function getParameterAttributes(ReflectionParameter $param): array;

    /**
     * Gets a method parameter attribute
     *
     * @param ReflectionParameter $param         The ReflectionParameter of the parameter
     *                                           from which the attributes should be read.
     * @param class-string<T>     $attributeName
     *
     * @return T|null The Annotation/Attribute or NULL, if the requested annotation does not exist.
     *
     * @template T of object
     */
    public function getParameterAttribute(ReflectionParameter $param, string $attributeName): object|null;
}
