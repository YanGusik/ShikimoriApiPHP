<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;
use ShikimoriAPI\ShikimoriAPIAuthException;
use ShikimoriAPI\ShikimoriAPIException;
use ShikimoriAPI\ShikimoriAPINotFoundException;
use ShikimoriAPI\ShikimoriAPIValidationException;

class Clubs
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    /**
     * @param array $options
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function getAll(array $options): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/clubs', $options)['body'];
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
        return $this->api->sendRequestWithoutToken('GET', '/clubs/' . $id)['body'];
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
        return $this->api->sendRequestWithToken('PUT', '/clubs/' . $id, $options)['body'];
    }

    /**
     * @param int $id
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function animes(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/clubs/' . $id . '/animes')['body'];
    }

    /**
     * @param int $id
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function mangas(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/clubs/' . $id . '/mangas')['body'];
    }

    /**
     * @param int $id
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function ranobe(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/clubs/' . $id . '/ranobe')['body'];
    }

    /**
     * @param int $id
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function characters(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/clubs/' . $id . '/characters')['body'];
    }

    /**
     * @param int $id
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function members(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/clubs/' . $id . '/members')['body'];
    }

    /**
     * @param int $id
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function images(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/clubs/' . $id . '/images')['body'];
    }

    /**
     * @param int $id
     * @return bool
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function join(int $id): bool
    {
        return $this->api->sendRequestWithToken('POST', '/clubs/' . $id . '/join')['status'] === 200;
    }

    /**
     * @param int $id
     * @return bool
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function leave(int $id): bool
    {
        return $this->api->sendRequestWithToken('POST', '/clubs/' . $id . '/leave')['status'] === 200;
    }
}
