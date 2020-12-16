<?php

declare(strict_types=1);

namespace Koriym\Attributes;

#[Cacheable]
class Fake
{
    #[Inject]

    public function setKey(#[Named('auth_key')] string $authKey): void // named binding
    {
    }

    #[PaidMemberOnly]
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
