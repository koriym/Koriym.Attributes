<?php

namespace Koriym\Attributes;

use Koriym\Attributes\Annotation\FooClass;

/**
 * @FooClass
 */
#[FooClass]
class FakeInterfaceRead
{
    /**
     * @FooClass
     *
     * @var string
     */
    #[FooClass]
    public $prop;

    /**
     * @FooClass
     */
    #[FooClass]
    public function subscribe(): void
    {
    }

    public function noAttribute(): void
    {
    }
}
