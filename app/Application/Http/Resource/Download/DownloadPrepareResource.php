<?php

declare(strict_types=1);

namespace Application\Http\Resource\Download;

use Core\Common\PreparedResponse;
use Core\Enums\TokenType;
use Hyperf\Resource\Json\JsonResource;

class DownloadPrepareResource extends JsonResource
{
    /** @var PreparedResponse */
    public mixed $resource;

    public ?string $wrap = null;

    public function toArray(): array
    {
        return [
            'url' => $this->resource->getUrl(),
            'id'  => $this->resource->getIdVideo(),
        ];
    }
}
