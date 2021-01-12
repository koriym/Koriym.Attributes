<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Doctrine\Common\Annotations\Reader;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

use const PHP_VERSION_ID;

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
        if ($this->php8) {
            $annotations = $this->attributeReader->getMethodAnnotations($method);
            if ($annotations) {
                return $annotations;
            }
        }

        return $this->annotationReader->getMethodAnnotations($method);
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
        if ($this->php8) {
            $annotations = $this->attributeReader->getClassAnnotations($class);
            if ($annotations) {
                return $annotations;
            }
        }

        return $this->annotationReader->getClassAnnotations($class);
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
            $annotation = $this->attributeReader->getClassAnnotation($class, $annotationName);
            if ($annotation) {
                return $annotation;
            }
        }

        return $this->annotationReaedr->getClassAnnotation($class, $annotationName);
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
    public function getPropertyAnnotations(ReflectionProperty $property): array
    {
        if ($this->php8) {
            $annotations = $this->attributeReader->getPropertyAnnotations($property);
            if ($annotations) {
                return $annotations;
            }
        }

        return $this->annotationReader->getPropertyAnnotations($property);
    }

    /**
     * {@inheritDoc}
     */
    public function getPropertyAnnotation(ReflectionProperty $property, $annotationName): ?object
    {
        if ($this->php8) {
            $annotations = $this->attributeReader->getPropertyAnnotation($property, $annotationName);
            if ($annotations) {
                return $annotations;
            }
        }

        return $this->annotationReader->getPropertyAnnotation($property, $annotationName);
    }
}
