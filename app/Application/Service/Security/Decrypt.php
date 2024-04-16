<?php

declare(strict_types=1);

namespace Application\Service\Security;

use Defuse\Crypto\Crypto;
use Exception;
use Hyperf\Contract\ConfigInterface;

class Decrypt
{
    public function __construct(
        private Key $key
    ) {
    }

    public function run(string $encrypted): string
    {
        return Crypto::decrypt($encrypted, $this->key->run());
    }
}
