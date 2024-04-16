<?php

declare(strict_types=1);

namespace Application\Command;

use Application\Service\Download\Prepare;
use Application\Service\Download\Url;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Hyperf\Di\Annotation\Inject;
use Symfony\Component\Console\Input\InputOption;

#[Command(name: 'video:download', description: 'Download Video', options: [
    [self::OPTION_URL, 'u', InputOption::VALUE_REQUIRED, 'Video URL'],
])]
class VideoDownloadCommand extends HyperfCommand
{
    private const OPTION_URL = 'url';

    #[Inject()]
    private Prepare $prepare;

    #[Inject()]
    private Url $url;

    public function handle()
    {
        $url = $this->option(self::OPTION_URL);

        if (empty($url)) {
            return 1;
        }

        $response = $this->prepare->run($url);
        $path     = $this->url->run($response->getIdVideo(), $response->getUrl());

        dd($path);
    }
}
