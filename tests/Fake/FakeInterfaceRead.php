<?php

namespace Koriym\Attributes\Tests\Fake;

use Koriym\Attributes\Tests\Fake\Annotation\FakeFooClass;
use Koriym\Attributes\Tests\Fake\Annotation\FooClassFake;

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
