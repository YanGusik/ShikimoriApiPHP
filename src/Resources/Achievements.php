<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;
use ShikimoriAPI\ShikimoriAPIAuthException;
use ShikimoriAPI\ShikimoriAPIException;
use ShikimoriAPI\ShikimoriAPINotFoundException;

class Achievements
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    /**
     * @param int $user_id
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     */
    public function achievements(int $user_id): array
    {
        return $this->api->sendRequestWithToken('GET', '/achievements?user_id=' . $user_id)['body'];
    }
}
