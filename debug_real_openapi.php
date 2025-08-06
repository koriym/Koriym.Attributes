<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Doctrine\Common\Annotations\AnnotationReader;
use Koriym\Attributes\AttributeReader;
use Koriym\Attributes\DualReader;
use OpenApi\Attributes as OA;

echo "Testing real OpenAPI structure behavior...\n\n";

// Create exact Issue #26 scenario with real OpenAPI classes
$params = [
    new OA\Parameter(
        name: "param1",
        in: "query",
        required: false,
        schema: new OA\Schema(type: "string")
    ),
    new OA\Parameter(
        name: "param2",
        in: "query",
        required: false,
        schema: new OA\Schema(type: "string")
    ),
    new OA\Parameter(
        name: "param3",
        in: "query",
        required: false,
        schema: new OA\Schema(type: "string")
    ),
    new OA\Parameter(
        name: "param4",
        in: "query",
        required: false,
        schema: new OA\Schema(type: "string")
    )
];

$annotations = []; // Empty annotations array

echo "Testing array_unique with SORT_REGULAR (current DualReader implementation):\n";
try {
    $start = microtime(true);
    $result = array_unique(array_merge($annotations, $params), SORT_REGULAR);
    $time = microtime(true) - $start;
    echo "✅ Success: " . count($result) . " parameters processed in " . number_format($time, 6) . "s\n";
} catch (Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Error at: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\nTesting early return fix (empty annotations):\n";
try {
    $start = microtime(true);
    if (count($annotations) === 0) {
        $result = $params;
    } else {
        $result = array_unique(array_merge($annotations, $params), SORT_REGULAR);
    }
    $time = microtime(true) - $start;
    echo "✅ Success: " . count($result) . " parameters processed in " . number_format($time, 6) . "s\n";
} catch (Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\nInspecting OpenAPI object structure...\n";
$param = new OA\Parameter(
    name: "test",
    in: "query",
    schema: new OA\Schema(type: "string")
);

echo "Parameter class: " . get_class($param) . "\n";
echo "Schema class: " . get_class($param->schema) . "\n";

// Try to trigger deep comparison by creating more complex structures
echo "\nTesting with very large number of similar parameters...\n";
$manyParams = [];
for ($i = 1; $i <= 20; $i++) {
    $manyParams[] = new OA\Parameter(
        name: "param$i",
        in: "query",
        required: false,
        schema: new OA\Schema(type: "string", description: "Parameter $i description with some text to make it different")
    );
}

try {
    $start = microtime(true);
    $result = array_unique($manyParams, SORT_REGULAR);
    $time = microtime(true) - $start;
    echo "✅ Success with 20 params: " . count($result) . " processed in " . number_format($time, 6) . "s\n";
} catch (Throwable $e) {
    echo "❌ Error with many params: " . $e->getMessage() . "\n";
}