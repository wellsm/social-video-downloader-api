<?php

declare(strict_types=1);

use Hyperf\HttpServer\Router\Router;
use Application\Http\Controller;
use Application\Http\Middleware;

Router::addGroup('/api', function () {
    Router::post('/auth', Controller\User\UserAuthController::class);
    Router::get('/download', Controller\Download\UrlController::class);

    Router::addGroup('', function () {
        Router::post('/download', Controller\Download\PrepareController::class);
    }, [
        'middleware' => [
            Middleware\VerifyCodeMiddleware::class,
        ]
    ]);
});
