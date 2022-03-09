<?php

declare(strict_types=1);

namespace Koriym\Attributes\Tests;

use Koriym\Attributes\Tests\Fake\Annotation\FakeAssisted;
use Koriym\Attributes\Tests\Fake\Annotation\FakeCacheable;
use Koriym\Attributes\Tests\Fake\Annotation\FakeFooClass;
use Koriym\Attributes\Tests\Fake\Annotation\FooClass;
use Koriym\Attributes\Tests\Fake\Annotation\FakeHttpCache;
use Koriym\Attributes\Tests\Fake\Annotation\FakeInject;
use Koriym\Attributes\Tests\Fake\Annotation\FakeLoggable;
use Koriym\Attributes\Tests\Fake\Annotation\FakeNamed;
use Koriym\Attributes\Tests\Fake\Annotation\FakeTransactional;
use PDO;

#[FakeFooClass]
#[FakeCacheable]
class FakeAttributes
{
    #[FakeInject]
    #[FakeFooClass]
    public string $prop;

    #[FakeInject]
    #[FakeFooClass]
    public function setKey(#[FakeNamed('auth_key')] string $authKey): void // named binding
    {
    }

    #[FakeTransactional]
    #[FakeLoggable]
    #[FakeHttpCache(isPrivate: true, maxAge: 50)]
    public function subscribe(string $id): void  // intercepted
    {
    }

    public function getPdo(string $id, #[FakeAssisted ] PDO $pdo): void // runtime injection
    {
    }
}
