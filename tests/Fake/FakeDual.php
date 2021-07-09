<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Koriym\Attributes\Annotation\FakeCacheable;
use Koriym\Attributes\Annotation\FakeFooClass;
use Koriym\Attributes\Annotation\FakeHttpCache;
use Koriym\Attributes\Annotation\FakeInject;
use Koriym\Attributes\Annotation\FakeLoggable;
use Koriym\Attributes\Annotation\FakeTransactional;

#[FakeFooClass]
#[FakeCacheable]
/**
 * @FakeCacheable
 * @FakeFooClass
 */
class FakeDual
{
    /**
     * @FakeInject
     * @FakeFooClass
     *
     * @var string
     */
    #[FakeInject]
    #[FakeFooClass]
    public $prop;

    /**
     * @FakeInject
     */
    #[FakeInject]
    #[FakeFooClass]
    public function setKey(string $authKey): void // named binding
    {
    }

    /**
     * @FakeTransactional
     * @FakeLoggable
     * @FakeHttpCache(isPrivate=true, maxAge=50)
     */
    #[FakeTransactional]
    #[FakeLoggable]
    #[FakeHttpCache(isPrivate: true, maxAge: 50)]
    public function subscribe(string $id): void  // intercepted
    {
    }
}
