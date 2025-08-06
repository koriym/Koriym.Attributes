<?php

declare(strict_types=1);

namespace Koriym\Attributes\Tests\Fake;

use Koriym\Attributes\Tests\Fake\FakeOpenAPIParameter;
use Koriym\Attributes\Tests\Fake\FakeSchema;

final class FakeMultipleParametersClass
{
    #[FakeOpenAPIParameter(
        name: "param1",
        in: "query",
        required: false,
        schema: new FakeSchema(type: "string")
    )]
    #[FakeOpenAPIParameter(
        name: "param2", 
        in: "query",
        required: false,
        schema: new FakeSchema(type: "string")
    )]
    #[FakeOpenAPIParameter(
        name: "param3",
        in: "query", 
        required: false,
        schema: new FakeSchema(type: "string")
    )]
    public function threeParameters(): void
    {
    }

    #[FakeOpenAPIParameter(
        name: "param1",
        in: "query",
        required: false,
        schema: new FakeSchema(type: "string")
    )]
    #[FakeOpenAPIParameter(
        name: "param2",
        in: "query", 
        required: false,
        schema: new FakeSchema(type: "string")
    )]
    #[FakeOpenAPIParameter(
        name: "param3",
        in: "query",
        required: false,
        schema: new FakeSchema(type: "string")
    )]
    #[FakeOpenAPIParameter(
        name: "param4",
        in: "query",
        required: false,
        schema: new FakeSchema(type: "string")
    )]
    public function fourParameters(): void
    {
    }

    #[FakeOpenAPIParameter(
        name: "param1",
        in: "query",
        required: false,
        schema: new FakeSchema(type: "string")
    )]
    #[FakeOpenAPIParameter(
        name: "param2",
        in: "query",
        required: false,
        schema: new FakeSchema(type: "integer")
    )]
    #[FakeOpenAPIParameter(
        name: "param3",
        in: "query",
        required: true,
        schema: new FakeSchema(type: "boolean")
    )]
    #[FakeOpenAPIParameter(
        name: "param4",
        in: "query",
        required: false,
        schema: new FakeSchema(type: "string")
    )]
    #[FakeOpenAPIParameter(
        name: "param5",
        in: "query",
        required: false,
        schema: new FakeSchema(type: "array")
    )]
    public function fiveParameters(): void
    {
    }
}