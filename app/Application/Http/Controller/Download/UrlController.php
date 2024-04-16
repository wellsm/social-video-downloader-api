<?php

declare(strict_types=1);

namespace Application\Http\Controller\Download;

use Application\Service\Download\Url;
use Hyperf\HttpServer\Request;
use Hyperf\HttpServer\Response;

class UrlController
{
    public function __invoke(Request $request, Response $response, Url $service)
    {
        $filename = $request->query('filename');
        $filename = "{$filename}.mp4";

        return $response->download(
            $service->run($filename, $request->query('value')),
            $filename
        );
    }
}
