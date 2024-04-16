<?php

declare (strict_types=1);

namespace Application\Service\Download;

use Application\Service\Security\Decrypt;
use Hyperf\Guzzle\ClientFactory;

class Url
{
    public function __construct(
        private ClientFactory $client,
        private Decrypt $decrypt
    ) {}

    public function run(string $filename, string $encrypted): string
    {
        $path = tempnam("/tmp", $filename);
        $tmp  = fopen($path, 'a+');
        $url  = $this->decrypt->run($encrypted);

        $this->client->create()->get($url, ['sink' => $tmp]);

        return $path;
    }
}