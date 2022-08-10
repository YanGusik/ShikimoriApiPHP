<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;

class Videos
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    public function getAll(int $animeId): array
    {
        return $this->api->sendRequestWithToken('GET', "/animes/{$animeId}/videos")['body'];
    }

    public function create(int $animeId, array $options): array
    {
        return $this->api->sendRequestWithToken('POST', "/animes/{$animeId}/videos", $options)['body'];
    }

    public function delete(int $animeId, int $id): bool
    {
        return $this->api->sendRequestWithToken('DELETE', "/animes/{$animeId}/videos/{$id}")['status'] === 200;
    }
}
