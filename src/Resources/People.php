<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;
use ShikimoriAPI\ShikimoriAPIAuthException;
use ShikimoriAPI\ShikimoriAPIException;
use ShikimoriAPI\ShikimoriAPINotFoundException;

class People
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    public function get(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/people/' . $id)['body'];
    }

    public function search(array $options): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/people/search', $options)['body'];
    }
}
