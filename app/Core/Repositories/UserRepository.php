<?php

declare(strict_types=1);

namespace Core\Repositories;

use Core\Entities\UserEntity;
use Core\ValueObject\UserCodeValueObject;

interface UserRepository
{
    public function getUserById(int $id): ?UserEntity;

    public function getUserByCode(UserCodeValueObject $email): ?UserEntity;
}
