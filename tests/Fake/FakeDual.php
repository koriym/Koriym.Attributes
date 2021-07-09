<?php

declare(strict_types=1);

namespace Koriym\Attributes\Tests\Fake;

use Koriym\Attributes\Tests\Fake\Annotation\FakeCacheable;
use Koriym\Attributes\Tests\Fake\Annotation\FakeFooClass;
use Koriym\Attributes\Tests\Fake\Annotation\FakeHttpCache;
use Koriym\Attributes\Tests\Fake\Annotation\FakeInject;
use Koriym\Attributes\Tests\Fake\Annotation\FakeLoggable;
use Koriym\Attributes\Tests\Fake\Annotation\FakeTransactional;

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
