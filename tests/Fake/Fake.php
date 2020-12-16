<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Koriym\Attributes\Annotation\Assisted;
use Koriym\Attributes\Annotation\Cacheable;
use Koriym\Attributes\Annotation\HttpCache;
use Koriym\Attributes\Annotation\Inject;
use Koriym\Attributes\Annotation\Loggable;
use Koriym\Attributes\Annotation\Named;
use Koriym\Attributes\Annotation\PaidMemberOnly;
use Koriym\Attributes\Annotation\Transactional;

#[PaidMemberOnly]
#[Cacheable]
class Fake
{
    #[Inject]

    public function setKey(#[Named('auth_key')] string $authKey): void // named binding
    {
    }

    #[Transactional]
    #[Loggable]
    #[HttpCache(isPrivate: true, maxAge: 50)]

    public function subscribe(string $id): void  // intercepted
    {
    }

    public function getPdo(string $id, #[Assisted ] $pdo): void // runtime injection
    {
    }
}
