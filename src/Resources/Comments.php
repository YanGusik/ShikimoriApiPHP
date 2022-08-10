<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;

class Comments
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    public function getAll(array $options): array
    {
        return $this->api->sendRequestWithToken('GET', '/comments', $options)['body'];
    }

    public function get(int $id): array
    {
        return $this->api->sendRequestWithToken('GET', '/comments/' . $id)['body'];
    }

    public function create(array $options): bool
    {
        return $this->api->sendRequestWithToken('POST', '/comments', $options)['status'] === 200;
    }

    public function update(int $id, array $options): bool
    {
        return $this->api->sendRequestWithToken('PUT', '/comments/' . $id, $options)['status'] === 200;
    }

    public function delete(int $id): bool
    {
        return $this->api->sendRequestWithToken('DELETE', '/comments/' . $id)['status'] === 200;
    }
}
