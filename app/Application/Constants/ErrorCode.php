<?php

declare(strict_types=1);

namespace Application\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

#[Constants]
class ErrorCode extends AbstractConstants
{
    /**
     * @Message("Resource Not Found")
     */
    public const NOT_FOUND = 404;

    /**
     * @Message("Server Error！")
     */
    public const SERVER_ERROR = 500;

    /**
     * @Message("App Key is not defined")
     */
    public const APP_KEY_UNDEFINED = 1000;

    /**
     * @Message("Social Media not Ready")
     */
    public const SOCIAL_MEDIA_NOT_READY = 1001;

    /**
     * @Message("Social Media Download Error, Try Again")
     */
    public const SOCIAL_MEDIA_DOWNLOAD_ERROR = 1002;
}
