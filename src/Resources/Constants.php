<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;
use ShikimoriAPI\ShikimoriAPIAuthException;
use ShikimoriAPI\ShikimoriAPIException;
use ShikimoriAPI\ShikimoriAPINotFoundException;
use ShikimoriAPI\ShikimoriAPIValidationException;

class Constants
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
    public function anime(): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/constants/anime')['body'];
    }

    /**
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function manga(): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/constants/manga')['body'];
    }

    /**
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function userRate(): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/constants/user_rate')['body'];
    }

    /**
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function club(): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/constants/club')['body'];
    }

    /**
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function smileys(): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/constants/smileys')['body'];
    }
}
