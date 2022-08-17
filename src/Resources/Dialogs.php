<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;
use ShikimoriAPI\ShikimoriAPIAuthException;
use ShikimoriAPI\ShikimoriAPIException;
use ShikimoriAPI\ShikimoriAPINotFoundException;
use ShikimoriAPI\ShikimoriAPIValidationException;

class Dialogs
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    /**
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function getAll(): array
    {
        return $this->api->sendRequestWithToken('GET', '/dialogs')['body'];
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
        return $this->api->sendRequestWithToken('GET', '/dialogs/' . $id)['body'];
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
        return $this->api->sendRequestWithToken('DELETE', '/dialogs/' . $id)['status'] === 200;
    }
}
