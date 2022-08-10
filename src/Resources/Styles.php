<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;

class Styles
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    public function get(int $id): array
    {
        return $this->api->sendRequestWithToken('GET', '/styles/' . $id)['body'];
    }

    public function preview(array $options): array
    {
        return $this->api->sendRequestWithToken('POST', '/styles/preview', $options)['body'];
    }

    public function create(array $options): bool
    {
        return $this->api->sendRequestWithToken('POST', '/styles', $options)['status'] === 200;
    }

    public function update(int $id, array $options): bool
    {
        return $this->api->sendRequestWithToken('PUT', '/styles/' . $id, $options)['status'] === 200;
    }
}
