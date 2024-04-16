<?php

declare(strict_types=1);

namespace Application\Service\User;

use Application\Exception\Common\BusinessException;
use Application\Service\JWT\AccessTokenCreate;
use Core\DTO\User\UserAuthDTO;
use Core\Entities\UserEntity;
use Core\Repositories\UserRepository;
use Teapot\StatusCode\Http;

class UserAuth
{
    public function __construct(
        private UserRepository $repository,
        private AccessTokenCreate $token,
    ) {}

    public function run(UserAuthDTO $dto): UserEntity
    {
        $user = $this->repository->getUserByCode($dto->getCode());

        if (empty($user)) {
            throw new BusinessException(Http::NOT_FOUND);
        }

        return $user;
    }
}