<?php

namespace Koriym\Attributes;

use Koriym\Attributes\Annotation\FakeFooClass;
use Koriym\Attributes\Annotation\FooClassFake;

/**
 * @FakeFooClass
 */
#[FakeFooClass]
class FakeInterfaceRead
{
    /**
     * @FakeFooClass
     *
     * @var string
     */
    #[FakeFooClass]
    public $prop;

    /**
     * @FakeFooClass
     */
    #[FakeFooClass]
    public function subscribe(): void
    {
    }

    public function noAttribute(): void
    {
    }
}
