<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

interface AttributeReaderInterface
{
    /**
     * Gets the annotations applied to a class.
     *
     * @param ReflectionClass<object> $class
     *
     * @return array<object>
     */
    public function getClassAnnotations(ReflectionClass $class): array;

    /**
     * Gets a class annotation.
     *
     * @param ReflectionClass<object> $class
     * @param class-string<T>         $annotationName
     *
     * @return T|null
     *
     * @template T of object
     */
    public function getClassAnnotation(ReflectionClass $class, string $annotationName): object|null;

    /**
     * Gets the annotations applied to a method.
     *
     * @return array<object>
     */
    public function getMethodAnnotations(ReflectionMethod $method): array;

    /**
     * Gets a method annotation.
     *
     * @param class-string<T> $annotationName
     *
     * @return T|null
     *
     * @template T of object
     */
    public function getMethodAnnotation(ReflectionMethod $method, string $annotationName): object|null;

    /**
     * Gets the annotations applied to a property.
     *
     * @return array<object>
     */
    public function getPropertyAnnotations(ReflectionProperty $property): array;

    /**
     * Gets a property annotation.
     *
     * @param class-string<T> $annotationName
     *
     * @return T|null
     *
     * @template T of object
     */
    public function getPropertyAnnotation(ReflectionProperty $property, string $annotationName): object|null;
}
