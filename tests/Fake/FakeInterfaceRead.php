<?php


namespace Koriym\Attributes;

use Koriym\Attributes\Annotation\FooClass;

#[FooClass]
class FakeInterfaceRead
{
    #[FooClass]
    public string $prop;

    #[FooClass]
    public function subscribe(): void
    {
    }

    public function noAttribute(): void
    {
    }
}
