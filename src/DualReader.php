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
    private bool $php8;

    public function __construct(
        // phpcs:disable
        private Reader $annotationReaedr,
        private Reader $attributeReader
        // phpcs:enable
    ) {
        $this->php8 = PHP_VERSION_ID >= 80000;
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

        return $this->annotationReaedr->getMethodAnnotations($method);
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

        return $this->annotationReaedr->getClassAnnotations($class);
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
        if (! $this->php8) {
            goto doctrine_annotation;
        }

        $annotation = $this->attributeReader->getClassAnnotation($class, $annotationName);
        if ($annotation) {
            return $annotation;
        }

        doctrine_annotation:

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

        return $this->annotationReaedr->getMethodAnnotation($method, $annotationName);
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

        return $this->annotationReaedr->getPropertyAnnotations($property);
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

        return $this->annotationReaedr->getPropertyAnnotation($property, $annotationName);
    }
}
