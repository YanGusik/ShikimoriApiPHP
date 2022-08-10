<?php

declare(strict_types=1);

namespace ShikimoriAPI;

class ShikimoriAPINotFoundException extends \Exception
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