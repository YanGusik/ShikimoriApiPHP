<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;
use ShikimoriAPI\ShikimoriAPIAuthException;
use ShikimoriAPI\ShikimoriAPIException;
use ShikimoriAPI\ShikimoriAPINotFoundException;
use ShikimoriAPI\ShikimoriAPIValidationException;

class Messages
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    /**
     * @param int $id
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function get(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/messages' . $id)['body'];
    }

    /**
     * @param array $options
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function create(array $options): array
    {
        return $this->api->sendRequestWithToken('POST', '/messages', $options)['body'];
    }

    /**
     * @param int $id
     * @param array $options
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function update(int $id, array $options): array
    {
        return $this->api->sendRequestWithToken('PUT', '/messages/' . $id, $options)['body'];
    }

    /**
     * @param int $id
     * @return bool
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function delete(int $id): bool
    {
        return $this->api->sendRequestWithToken('DELETE', '/messages/' . $id)['status'] === 200;
    }

    /**
     * @param array $options
     * @return bool
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function markRead(array $options): bool
    {
        return $this->api->sendRequestWithToken('POST', '/messages/mark_read', $options)['status'] === 200;
    }

    /**
     * @param array $options
     * @return bool
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function readAll(array $options): bool
    {
        return $this->api->sendRequestWithToken('POST', '/messages/read_all', $options)['status'] === 200;
    }

    /**
     * @param array $options
     * @return bool
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function deleteAll(array $options): bool
    {
        return $this->api->sendRequestWithToken('POST', '/messages/delete_all', $options)['status'] === 200;
    }
}
