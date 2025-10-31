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

    /**
     * Gets the attributes applied to a method parameter.
     *
     * @param ReflectionParameter $param The ReflectionParameter of the parameter
     *                                   from which the attributes should be read.
     *
     * @return array<object> An array of Annotations/Attributes.
     */
    public function getParameterAnnotations(ReflectionParameter $param): array;

    /**
     * Gets a method parameter attribute
     *
     * @param ReflectionParameter $param      The ReflectionParameter of the parameter
     *                                        from which the attributes should be read.
     * @param class-string<T>     $annotation
     *
     * @return T|null The Annotation/Attribute or NULL, if the requested annotation does not exist.
     *
     * @template T of object
     */
    public function getParameterAnnotation(ReflectionParameter $param, string $annotation): object|null;
}
