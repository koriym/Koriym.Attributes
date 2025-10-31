<?php

declare(strict_types=1);

/**
 * Rector configuration for migrating from koriym/attributes 1.x to 2.x
 *
 * This configuration automates:
 * 1. Class name changes from Doctrine Annotations to Koriym AttributeReaderInterface
 * 2. Doctrine annotations (@Annotation) to PHP 8 attributes (#[Attribute])
 * 3. Method name changes from getXxxAnnotation(s) to getXxxAttribute(s)
 *
 * Usage:
 *   1. Install Rector and Doctrine rules:
 *      composer require --dev rector/rector rector/rector-doctrine
 *   2. Customize paths in this file to match your project structure
 *   3. Run: vendor/bin/rector process --config=rector-migrate.php
 *   4. Review changes and run tests
 *   5. If you have custom implementations, manually update method names
 *   6. Optional: Remove Rector after migration
 *
 * What this does:
 * - Converts @Route("/api") to #[Route("/api")]
 * - Converts Reader to AttributeReaderInterface
 * - Converts DualReader to AttributeReader
 * - Renames getClassAnnotations() to getClassAttributes()
 * - Renames getClassAnnotation() to getClassAttribute()
 * - Renames getMethodAnnotations() to getMethodAttributes()
 * - Renames getMethodAnnotation() to getMethodAttribute()
 * - Renames getPropertyAnnotations() to getPropertyAttributes()
 * - Renames getPropertyAnnotation() to getPropertyAttribute()
 * - Renames getParameterAnnotations() to getParameterAttributes()
 * - Renames getParameterAnnotation() to getParameterAttribute()
 *
 * @see https://github.com/koriym/Koriym.Attributes
 * @see https://www.doctrine-project.org/2022/11/04/annotations-to-attributes.html (Doctrine's migration guide)
 */

use Koriym\Attributes\AttributeReaderInterface;
use Rector\Config\RectorConfig;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
        // Customize these paths for your project:
        // __DIR__ . '/app',
        // __DIR__ . '/lib',
    ])
    ->withSets([
        // Convert Doctrine annotations to PHP 8 attributes
        // @see https://www.doctrine-project.org/2022/11/04/annotations-to-attributes.html
        DoctrineSetList::ANNOTATIONS_TO_ATTRIBUTES,
    ])
    ->withConfiguredRule(
        RenameClassRector::class,
        [
            // Replace Doctrine Reader with AttributeReaderInterface
            'Doctrine\Common\Annotations\Reader' => 'Koriym\Attributes\AttributeReaderInterface',

            // Replace AnnotationReader with AttributeReader
            'Doctrine\Common\Annotations\AnnotationReader' => 'Koriym\Attributes\AttributeReader',

            // Replace DualReader with AttributeReader (1.x to 2.x migration)
            'Koriym\Attributes\DualReader' => 'Koriym\Attributes\AttributeReader',
        ]
    )
    ->withConfiguredRule(
        RenameMethodRector::class,
        [
            // Rename getXxxAnnotation(s) methods to getXxxAttribute(s)
            new MethodCallRename(AttributeReaderInterface::class, 'getClassAnnotations', 'getClassAttributes'),
            new MethodCallRename(AttributeReaderInterface::class, 'getClassAnnotation', 'getClassAttribute'),
            new MethodCallRename(AttributeReaderInterface::class, 'getMethodAnnotations', 'getMethodAttributes'),
            new MethodCallRename(AttributeReaderInterface::class, 'getMethodAnnotation', 'getMethodAttribute'),
            new MethodCallRename(AttributeReaderInterface::class, 'getPropertyAnnotations', 'getPropertyAttributes'),
            new MethodCallRename(AttributeReaderInterface::class, 'getPropertyAnnotation', 'getPropertyAttribute'),
            new MethodCallRename(AttributeReaderInterface::class, 'getParameterAnnotations', 'getParameterAttributes'),
            new MethodCallRename(AttributeReaderInterface::class, 'getParameterAnnotation', 'getParameterAttribute'),
        ]
    )
    ->withPhpSets(php81: true);
