<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;

class Messages
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    public function get(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/messages' . $id)['body'];
    }

    public function create(array $options): array
    {
        return $this->api->sendRequestWithToken('POST', '/messages', $options)['body'];
    }

    public function update(int $id, array $options): array
    {
        return $this->api->sendRequestWithToken('PUT', '/messages/' . $id, $options)['body'];
    }

    public function delete(int $id): bool
    {
        return $this->api->sendRequestWithToken('DELETE', '/messages/' . $id)['status'] === 200;
    }

    public function markRead(array $options): bool
    {
        return $this->api->sendRequestWithToken('POST', '/messages/mark_read', $options)['status'] === 200;
    }

    public function readAll(array $options): bool
    {
        return $this->api->sendRequestWithToken('POST', '/messages/read_all', $options)['status'] === 200;
    }

    public function deleteAll(array $options): bool
    {
        return $this->api->sendRequestWithToken('POST', '/messages/delete_all', $options)['status'] === 200;
    }
}
