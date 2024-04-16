<?php

declare (strict_types=1);

namespace Core\Common;

interface Downloader
{
    public function run(string $url): PreparedResponse;
}