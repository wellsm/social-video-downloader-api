<?php

declare (strict_types=1);

namespace Application\Service\Security;

use Defuse\Crypto\Key as CryptoKey;
use Exception;

class Key
{
    private const string PATH = BASE_PATH . '/storage/crypto.key';

    public function run(): CryptoKey
    {
        $key = $this->loadFromFile()
            ?? CryptoKey::createNewRandomKey();

        if (file_exists(self::PATH)) {
            return $key;
        }

        $value = $key->saveToAsciiSafeString();

        file_put_contents(self::PATH, $value);

        return $key;
    }

    private function loadFromFile(): ?CryptoKey
    {
        try {
            return CryptoKey::loadFromAsciiSafeString(
                file_get_contents(self::PATH)
            );
        } catch (Exception $e) {
            return null;
        }
    }
}