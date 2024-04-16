<?php

declare (strict_types=1);

namespace Core\Common;

use Core\Enums\LinkPlatform;

class PreparedResponse
{
    public function __construct(
        private array $sources = [],
        private ?string $idVideo = null,
        private ?string $url = null,
        private ?LinkPlatform $platform = null,
    ) {}

    public function getSources(): array
    {
        return $this->sources;
    }

    public function addSource(string $source): self
    {
        $this->sources[] = $source;

        return $this;
    }

    public function getIdVideo(): string
    {
        return $this->idVideo;
    }

    public function setIdVideo(string $idVideo): self
    {
        $this->idVideo = $idVideo;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getPlatform(): LinkPlatform
    {
        return $this->platform;
    }

    public function setPlatform(LinkPlatform $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    public function toArray(): array
    {
        return array_map(fn (string $source) => [
            'id'              => $this->idVideo,
            'platform'        => $this->platform->value,
            'source_url'      => $source,
            'destination_url' => $this->url,
            'created_at'      => date('Y-m-d H:i:s'),
        ], $this->sources);
    }
}