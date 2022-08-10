<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;
use ShikimoriAPI\ShikimoriAPIAuthException;
use ShikimoriAPI\ShikimoriAPIException;
use ShikimoriAPI\ShikimoriAPINotFoundException;

class Friends
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    public function create(int $id): bool
    {
        return $this->api->sendRequestWithToken('POST', "/friends/{$id}")['status'] === 200;
    }

    public function delete(int $id): bool
    {
        return $this->api->sendRequestWithToken('DELETE', "/friends/{$id}")['body'] === 200;
    }
}
