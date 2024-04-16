<?php

declare (strict_types=1);

namespace Application\Service\Download;

use Application\Constants\ErrorCode;
use Application\Exception\Common\BusinessException;
use Application\Service\Downloader\Pinterest;
use Application\Service\Downloader\Tiktok;
use Application\Service\Security\Encrypt;
use Core\Common\PreparedResponse;
use Core\Enums\LinkPlatform;
use Hyperf\DbConnection\Db;
use Hyperf\Stringable\Str;

use function Hyperf\Support\make;

class Prepare
{
    public function __construct(
        private Encrypt $encrypt
    ) {}

    public function run(string $url): PreparedResponse
    {
        $response = $this->getLink($url);

        if (!empty($response)) {
            return $response->setUrl($this->encrypt->run($response->getUrl()));
        }

        $response = $this->downloader($url);

        Db::table('links')->upsert($response->toArray(), ['source_url']);

        return $response->setUrl($this->encrypt->run($response->getUrl()));
    }

    private function getLink(string $url): ?PreparedResponse
    {
        $link = Db::table('links')->where('source_url', $url)->first();

        if (empty($link)) {
            return null;
        }

        $response = new PreparedResponse();
    
        return $response->addSource($link['source_url'])
            ->setIdVideo($link['id'])
            ->setUrl($link['destination_url'])
            ->setPlatform(LinkPlatform::from($link['platform']));
    }

    private function downloader(string $url): PreparedResponse
    {
        if (Str::containsIgnoreCase($url, Tiktok::DOMAIN)) {
            return make(Tiktok::class)->run($url);
        }

        if (Str::containsIgnoreCase($url, Pinterest::DOMAIN)) {
            return make(Pinterest::class)->run($url);
        }

        throw new BusinessException(ErrorCode::SOCIAL_MEDIA_NOT_READY);
    }
}