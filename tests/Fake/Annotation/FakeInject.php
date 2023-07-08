<?php


namespace Koriym\Attributes\Tests\Fake\Annotation;

use Attribute;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;

/**
 * @Annotation
 * @NamedArgumentConstructor
 */
#[Attribute]
final class FakeInject
{
    public $optional;
    public function __construct(bool $optional = false)
    {
        $this->optional = $optional;
    }
}
