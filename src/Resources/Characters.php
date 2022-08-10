<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;
use ShikimoriAPI\ShikimoriAPIAuthException;
use ShikimoriAPI\ShikimoriAPIException;
use ShikimoriAPI\ShikimoriAPINotFoundException;

class Characters
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
     */
    public function get(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/characters/' . $id)['body'];
    }

    /**
     * @param string $search
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     */
    public function search(string $search): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/characters/search?' . $search)['body'];
    }
}
