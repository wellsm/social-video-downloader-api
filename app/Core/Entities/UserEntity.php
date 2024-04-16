<?php

declare(strict_types=1);

namespace Core\Entities;

use Core\Common\DateTimes;
use Core\ValueObject\EmailValueObject;
use Core\ValueObject\HashedPasswordValueObject;
use Core\ValueObject\PasswordValueObject;
use Core\ValueObject\UserCodeValueObject;

interface UserEntity extends DateTimes
{
    public function getId(): int;

    public function getName(): string;

    public function setName(string $name): self;

    public function getCode(): UserCodeValueObject;

    public function setCode(UserCodeValueObject $code): self;

    public function toArray(): array;
}
