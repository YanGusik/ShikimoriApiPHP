<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;
use ShikimoriAPI\ShikimoriAPIAuthException;
use ShikimoriAPI\ShikimoriAPIException;
use ShikimoriAPI\ShikimoriAPINotFoundException;
use ShikimoriAPI\ShikimoriAPIValidationException;

class Appear
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api)
    {
        $this->api = $api;
    }

    /**
     * @param array $ids
     * @return bool
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function appears(array $ids): bool
    {
        return $this->api->sendRequestWithToken('POST', '/appears', [
            'ids' => implode(',', $ids)
        ])['status'] === 200;
    }
}
