<?php

declare (strict_types=1);

namespace Application\Service\Security;

use Defuse\Crypto\Crypto;
use Hyperf\Contract\ConfigInterface;

class Encrypt
{
    public function __construct(
        private ConfigInterface $config,
        private Key $key
    ) {}

    public function run(string $message): string
    {
        return Crypto::encrypt($message, $this->key->run());
    }
}