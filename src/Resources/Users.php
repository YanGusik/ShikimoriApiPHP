<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;

class Users
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    public function whoami(): array
    {
        return $this->api->sendRequestWithToken('GET', '/users/whoami')['body'];
    }
}
