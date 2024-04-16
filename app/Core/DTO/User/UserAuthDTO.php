<?php

declare(strict_types=1);

namespace Core\DTO\User;

use Core\Common\DTO;
use Core\ValueObject\UserCodeValueObject;

final class UserAuthDTO extends DTO
{
    public string $code;

    public function getCode(): UserCodeValueObject
    {
        return new UserCodeValueObject($this->code);
    }
}