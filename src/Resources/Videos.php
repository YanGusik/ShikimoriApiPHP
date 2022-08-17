<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;
use ShikimoriAPI\ShikimoriAPIAuthException;
use ShikimoriAPI\ShikimoriAPIException;
use ShikimoriAPI\ShikimoriAPINotFoundException;
use ShikimoriAPI\ShikimoriAPIValidationException;

class Videos
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    /**
     * @param int $animeId
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function getAll(int $animeId): array
    {
        return $this->api->sendRequestWithToken('GET', "/animes/$animeId/videos")['body'];
    }

    /**
     * @param int $animeId
     * @param array $options
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function create(int $animeId, array $options): array
    {
        return $this->api->sendRequestWithToken('POST', "/animes/$animeId/videos", $options)['body'];
    }

    /**
     * @param int $animeId
     * @param int $id
     * @return bool
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function delete(int $animeId, int $id): bool
    {
        return $this->api->sendRequestWithToken('DELETE', "/animes/$animeId/videos/$id")['status'] === 200;
    }
}
