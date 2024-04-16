<?php

declare(strict_types=1);

namespace Core\ValueObject;

use DomainException;

class UserCodeValueObject
{
    private string $value;

    public function __construct(string $value)
    {
        if (strlen($value) != 36) {
            throw new DomainException("Invalid Code: '{$value}' Must Have 36 Characters.");
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
