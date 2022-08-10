<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;

class Topics
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    public function getAll(array $options): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/topics', $options)['body'];
    }

    public function updates(array $options): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/topics/updates', $options)['body'];
    }

    public function hot(array $options): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/topics/hot', $options)['body'];
    }

    public function get(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/topics/' . $id)['body'];
    }

    public function create(array $options): bool
    {
        return $this->api->sendRequestWithToken('POST', '/topics', $options)['status'] === 200;
    }

    public function update(int $id, array $options): bool
    {
        return $this->api->sendRequestWithToken('PUT', '/topics/' . $id, $options)['status'] === 200;
    }

    public function delete(int $id): bool
    {
        return $this->api->sendRequestWithToken('DELETE', '/topics/' . $id)['status'] === 200;
    }
}
