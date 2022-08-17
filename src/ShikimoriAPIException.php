<?php

declare(strict_types=1);

namespace ShikimoriAPI;

use Exception;

class ShikimoriAPIException extends Exception
{
    public const TOKEN_EXPIRED = 'The access token is invalid';
    public const RATE_LIMIT_STATUS = 429;

    private $reason;

    public function __construct(string $message = "", int $code = 0, $reason = null)
    {
        $this->reason = $reason;
        parent::__construct($message, $code);
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function hasExpiredToken(): bool
    {
        return $this->getMessage() === self::TOKEN_EXPIRED;
    }

    public function isRateLimited(): bool
    {
        return $this->getCode() === self::RATE_LIMIT_STATUS;
    }

    public function setReason($reason)
    {
        $this->reason = $reason;
    }
}
