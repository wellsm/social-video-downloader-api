<?php

declare(strict_types=1);

namespace Application\Http\Middleware;

use Application\Constants\App;
use Core\Repositories\UserRepository;
use Core\ValueObject\UserCodeValueObject;
use Hyperf\HttpMessage\Exception\ForbiddenHttpException;
use Hyperf\HttpMessage\Exception\UnauthorizedHttpException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VerifyCodeMiddleware implements MiddlewareInterface
{
    public function __construct(
        private UserRepository $repository,
    ) { }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $query = $request->getQueryParams();
        $code  = $query[App::CODE_HEADER] ?? $request->getHeaderLine(App::CODE_HEADER);

        if (empty($code)) {
            throw new UnauthorizedHttpException();
        }

        $user = $this->repository->getUserByCode(new UserCodeValueObject($code));

        if (empty($user)) {
            throw new ForbiddenHttpException();
        }

        return $handler->handle($request);
    }
}
