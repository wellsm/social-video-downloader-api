<?php

declare(strict_types=1);

namespace Application\Http\Controller\Download;

use Application\Http\Resource\Download\DownloadPrepareResource;
use Application\Service\Download\Prepare;
use Hyperf\HttpServer\Request;

class PrepareController
{
    public function __invoke(Request $request, Prepare $service)
    {
        return new DownloadPrepareResource(
            $service->run($request->post('url'))
        );
    }
}
