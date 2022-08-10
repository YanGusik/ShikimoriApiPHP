<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;
use ShikimoriAPI\ShikimoriAPIAuthException;
use ShikimoriAPI\ShikimoriAPIException;
use ShikimoriAPI\ShikimoriAPINotFoundException;

class Constants
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    public function anime(): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/constants/anime')['body'];
    }

    public function manga(): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/constants/manga')['body'];
    }

    public function userRate(): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/constants/user_rate')['body'];
    }

    public function club(): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/constants/club')['body'];
    }

    public function smileys(): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/constants/smileys')['body'];
    }
}
