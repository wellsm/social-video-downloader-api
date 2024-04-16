<?php

declare(strict_types=1);

namespace Application\Http\Controller\User;

use Application\Http\Request\User\UserAuthRequest;
use Application\Http\Resource\User\UserResource;
use Application\Service\User\UserAuth;
use Core\DTO\User\UserAuthDTO;

class UserAuthController
{
    public function __invoke(UserAuthRequest $request, UserAuth $service)
    {
        return new UserResource(
            $service->run(
                new UserAuthDTO($request->validated())
            )
        );
    }
}
