<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;
use ShikimoriAPI\ShikimoriAPIAuthException;
use ShikimoriAPI\ShikimoriAPIException;
use ShikimoriAPI\ShikimoriAPINotFoundException;
use ShikimoriAPI\ShikimoriAPIValidationException;

class Styles
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
        return $this->api->sendRequestWithToken('GET', '/styles/' . $id)['body'];
    }

    /**
     * @param array $options
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function preview(array $options): array
    {
        return $this->api->sendRequestWithToken('POST', '/styles/preview', $options)['body'];
    }

    /**
     * @param array $options
     * @return bool
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function create(array $options): bool
    {
        return $this->api->sendRequestWithToken('POST', '/styles', $options)['status'] === 200;
    }

    /**
     * @param int $id
     * @param array $options
     * @return bool
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function update(int $id, array $options): bool
    {
        return $this->api->sendRequestWithToken('PUT', '/styles/' . $id, $options)['status'] === 200;
    }
}
