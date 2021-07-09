<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Koriym\Attributes\Annotation\FakeAssisted;
use Koriym\Attributes\Annotation\FakeCacheable;
use Koriym\Attributes\Annotation\FakeFooClass;
use Koriym\Attributes\Annotation\FooClass;
use Koriym\Attributes\Annotation\FakeHttpCache;
use Koriym\Attributes\Annotation\FakeInject;
use Koriym\Attributes\Annotation\FakeLoggable;
use Koriym\Attributes\Annotation\FakeNamed;
use Koriym\Attributes\Annotation\FakeTransactional;
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
