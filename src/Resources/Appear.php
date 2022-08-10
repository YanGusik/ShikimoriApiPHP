<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;
use ShikimoriAPI\ShikimoriAPIAuthException;
use ShikimoriAPI\ShikimoriAPIException;
use ShikimoriAPI\ShikimoriAPINotFoundException;

class Appear
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    /**
     * @param array $ids
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     */
    public function appears(array $ids): bool
    {
        return $this->api->sendRequestWithToken('POST', '/appears', [
            'ids' => implode(',', $ids)
        ])['status'] === 200;
    }
}
