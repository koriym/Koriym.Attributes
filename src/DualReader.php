<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Doctrine\Common\Annotations\Reader;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

use function array_merge;
use function array_unique;

use const PHP_VERSION_ID;
use const SORT_REGULAR;

final class DualReader implements Reader
{
    /** @var bool */
    private $php8;

    /** @var Reader */
    private $annotationReader;

    /** @var Reader */
    private $attributeReader;

    public function __construct(Reader $annotationReader, Reader $attributeReader)
    {
        $this->php8 = PHP_VERSION_ID >= 80000;
        $this->annotationReader = $annotationReader;
        $this->attributeReader = $attributeReader;
    }

    /**
     * {@inheritDoc}
     */
    public function getMethodAnnotations(ReflectionMethod $method): array
    {
        $annotations = $this->annotationReader->getMethodAnnotations($method);
        if (! $this->php8) {
            return $annotations;
        }

        $attributes = $this->attributeReader->getMethodAnnotations($method);

        return array_unique(array_merge($annotations, $attributes), SORT_REGULAR);
    }

    /**
     * {@inheritDoc}
     *
     * @psalm-param ReflectionClass $class
     * @phpstan-param ReflectionClass<object> $class
     *
     * @return array<object>
     */
    public function getClassAnnotations(ReflectionClass $class): array
    {
        $annotations = $this->annotationReader->getClassAnnotations($class);
        if (! $this->php8) {
            return $annotations;
        }

        $attributes = $this->attributeReader->getClassAnnotations($class);

        return array_unique(array_merge($annotations, $attributes), SORT_REGULAR);
    }

    /**
     * {@inheritDoc}
     */
    public function getPropertyAnnotations(ReflectionProperty $property): array
    {
        $annotations = $this->annotationReader->getPropertyAnnotations($property);
        if (! $this->php8) {
            return $annotations;
        }

        $attributes = $this->attributeReader->getPropertyAnnotations($property);

        return array_unique(array_merge($annotations, $attributes), SORT_REGULAR);
    }

    /**
     * {@inheritDoc}
     *
     * @param class-string<T> $annotationName
     * @psalm-param ReflectionClass $class
     * @phpstan-param ReflectionClass<object> $class
     *
     * @return T|null
     *
     * @template T of object
     */
    public function getClassAnnotation(ReflectionClass $class, $annotationName): ?object
    {
        if ($this->php8) {
            $attribute = $this->attributeReader->getClassAnnotation($class, $annotationName);
            if ($attribute) {
                return $attribute;
            }
        }

        return $this->annotationReader->getClassAnnotation($class, $annotationName);
    }

    /**
     * {@inheritDoc}
     */
    public function getMethodAnnotation(ReflectionMethod $method, $annotationName): ?object
    {
        if ($this->php8) {
            $annotations = $this->attributeReader->getMethodAnnotation($method, $annotationName);
            if ($annotations) {
                return $annotations;
            }
        }

        return $this->annotationReader->getMethodAnnotation($method, $annotationName);
    }

    /**
     * {@inheritDoc}
     */
    public function getPropertyAnnotation(ReflectionProperty $property, $annotationName): ?object
    {
        if ($this->php8) {
            $attribute = $this->attributeReader->getPropertyAnnotation($property, $annotationName);
            if ($attribute) {
                return $attribute;
            }
        }

        return $this->annotationReader->getPropertyAnnotation($property, $annotationName);
    }
}
