<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;
use ShikimoriAPI\ShikimoriAPIAuthException;
use ShikimoriAPI\ShikimoriAPIException;
use ShikimoriAPI\ShikimoriAPINotFoundException;

class Dialogs
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    public function getAll(): array
    {
        return $this->api->sendRequestWithToken('GET', '/dialogs')['body'];
    }

    public function get(int $id): array
    {
        return $this->api->sendRequestWithToken('GET', '/dialogs/' . $id)['body'];
    }

    public function delete(int $id): bool
    {
        return $this->api->sendRequestWithToken('DELETE', '/dialogs/' . $id)['status'] === 200;
    }
}
