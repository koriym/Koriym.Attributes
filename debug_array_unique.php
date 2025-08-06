<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Koriym\Attributes\Tests\Fake\FakeSchema;
use Koriym\Attributes\Tests\Fake\FakeOpenAPIParameter;

echo "Testing array_unique behavior with complex objects...\n\n";

// Create deeply nested circular-like structures
class DeepSchema {
    public $level1;
    public $level2;
    public $level3;
    
    public function __construct() {
        $this->level1 = new stdClass();
        $this->level1->data = str_repeat('deep', 1000); // Large string
        
        $this->level2 = new stdClass();
        $this->level2->nested = [];
        for ($i = 0; $i < 100; $i++) {
            $this->level2->nested[] = new stdClass();
        }
        
        $this->level3 = new stdClass();
        $this->level3->circular = $this; // Circular reference
    }
}

$param1 = new FakeOpenAPIParameter(
    name: "param1",
    in: "query",
    required: false,
    schema: new FakeSchema(type: "object")
);

$param2 = new FakeOpenAPIParameter(
    name: "param2", 
    in: "query",
    required: false,
    schema: new FakeSchema(type: "array")
);

$param3 = new FakeOpenAPIParameter(
    name: "param3",
    in: "query",
    required: true,
    schema: new FakeSchema(type: "object")
);

$param4 = new FakeOpenAPIParameter(
    name: "param4",
    in: "query",
    required: false,
    schema: new FakeSchema(type: "array")
);

// Add deep schemas to increase complexity
$param1->schema->properties = ['deep' => new DeepSchema()];
$param2->schema->items = new FakeSchema(type: "object");
$param3->schema->properties = ['deep' => new DeepSchema()];
$param4->schema->items = new FakeSchema(type: "object");

$attributes = [$param1, $param2, $param3, $param4];
$annotations = []; // Empty array like in issue

echo "Testing SORT_REGULAR (current implementation):\n";
try {
    $merged = array_merge($annotations, $attributes);
    $result = array_unique($merged, SORT_REGULAR);
    echo "✅ SORT_REGULAR succeeded, count: " . count($result) . "\n";
} catch (Throwable $e) {
    echo "❌ SORT_REGULAR failed: " . $e->getMessage() . "\n";
}

echo "\nTesting without array_unique (just array_merge):\n";
try {
    $merged = array_merge($annotations, $attributes);
    echo "✅ Array merge succeeded, count: " . count($merged) . "\n";
} catch (Throwable $e) {
    echo "❌ Array merge failed: " . $e->getMessage() . "\n";
}

echo "\nTesting early return approach:\n";
try {
    if (count($annotations) === 0) {
        $result = $attributes;
        echo "✅ Early return succeeded, count: " . count($result) . "\n";
    }
} catch (Throwable $e) {
    echo "❌ Early return failed: " . $e->getMessage() . "\n";
}