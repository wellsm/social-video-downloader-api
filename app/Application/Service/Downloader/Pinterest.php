<?php

declare (strict_types=1);

namespace Application\Service\Downloader;

use Application\Constants\ErrorCode;
use Application\Exception\Common\BusinessException;
use Campo\UserAgent;
use Core\Common\Downloader;
use Core\Common\PreparedResponse;
use Core\Enums\LinkPlatform;
use GuzzleHttp\RedirectMiddleware;
use GuzzleHttp\RequestOptions;
use Hyperf\Guzzle\ClientFactory;
use Symfony\Component\DomCrawler\Crawler;
use Hyperf\Stringable\Str;

class Pinterest implements Downloader
{
    public const array DOMAIN = ['br.pinterest.com', 'pin.it'];

    public function __construct(
        private ClientFactory $client
    ) { }

    public function run(string $url): PreparedResponse
    {
        $response = $this->client->create()
            ->get($url, [
                RequestOptions::ALLOW_REDIRECTS => [
                    'track_redirects' => true,
                ],
                RequestOptions::HEADERS => [
                    'User-Agent' => UserAgent::random()
                ]
            ]);

        $urls    = $response->getHeader(RedirectMiddleware::HISTORY_HEADER);
        $source  = strtok($urls[1] ?? $urls[0] ?? $url, '?');
        $idVideo = $this->idVideoFromURL($source);

        $html    = $response->getBody()->getContents();
        $crawler = new Crawler($html);
        $data    = $crawler->filter('video.hwa.kVc.MIw.L4E')->first();

        if (empty($data)) {
            throw new BusinessException(ErrorCode::SOCIAL_MEDIA_DOWNLOAD_ERROR);
        }

        $link = Str::replace(['iht', 'hls', 'm3u8'], ['mc', '720p', 'mp4'], $data->attr('src'));

        return new PreparedResponse([$url, $source], $idVideo, $link, LinkPlatform::Pinterest);
    }

    private function idVideoFromURL(string $url): ?string
    {
        preg_match('/pin\/(?<id>\w+)?/', $url, $matches);

        return $matches['id'] ?? null;
    }
}