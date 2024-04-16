<?php

declare (strict_types=1);

namespace Application\Service\Downloader;

use Campo\UserAgent;
use Core\Common\Downloader;
use Core\Common\PreparedResponse;
use Core\Enums\LinkPlatform;
use GuzzleHttp\RedirectMiddleware;
use GuzzleHttp\RequestOptions;
use Hyperf\Guzzle\ClientFactory;

class Tiktok implements Downloader
{
    public const array DOMAIN = ['www.tiktok.com', 'vm.tiktok.com'];

    private const FIXED_OPTIONS = [
        'iid'             => '7318518857994389254',
        'device_id'       => '7318517321748022790',
        'channel'         => 'googleplay',
        'app_name'        => 'musical_ly',
        'version_code'    => '300904',
        'device_platform' => 'android',
        'device_type'     => 'ASUS_Z01QD',
        'os_version'      => '9',
    ];

    public function __construct(
        private ClientFactory $client
    ) { }

    public function run(string $url): PreparedResponse
    {
        $preparedResponse = new PreparedResponse();
        $preparedResponse->addSource(trim($url, '/'));

        $idVideo  = $this->idVideo($url, $preparedResponse);
        $response = $this->client->create()
            ->get('https://api22-normal-c-alisg.tiktokv.com/aweme/v1/feed/', [
                RequestOptions::QUERY => self::FIXED_OPTIONS + [
                    'aweme_id' => $idVideo
                ],
                RequestOptions::HEADERS => [
                    'User-Agent' => UserAgent::random()
                ]
            ]);

        $data = $response->getBody()->getContents();
        $json = json_decode($data, true);
        $link = $json['aweme_list'][0]['video']['play_addr']['url_list'][0];

        return $preparedResponse
            ->setUrl($link)
            ->setIdVideo($idVideo)
            ->setPlatform(LinkPlatform::Tiktok);
    }

    private function idVideo(string $url, PreparedResponse $preparedResponse): string
    {
        return $this->idVideoFromURL($url)
            ?? $this->idVideoFromRedirection($url, $preparedResponse);
    }

    private function idVideoFromURL(string $url): ?string
    {
        preg_match('/video\/(?<id>\w+)?/', $url, $matches);

        return $matches['id'] ?? null;
    }

    private function idVideoFromRedirection(string $url, PreparedResponse $preparedResponse): string
    {
        $response = $this->client->create()->get($url, [
            RequestOptions::ALLOW_REDIRECTS => [
                'track_redirects' => true,
            ],
        ]);

        $url = strtok($response->getHeaderLine(RedirectMiddleware::HISTORY_HEADER), '?');

        $preparedResponse->addSource($url);

        return $this->idVideoFromURL($url);
    }
}