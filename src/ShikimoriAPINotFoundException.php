<?php

declare(strict_types=1);

namespace ShikimoriAPI;

use Exception;

class ShikimoriAPINotFoundException extends Exception
{
    private $reason;

    public function getReason()
    {
        return $this->reason;
    }
    public function setReason($reason)
    {
        $this->reason = $reason;
    }
}
