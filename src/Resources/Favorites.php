<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;

class Favorites
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    public function create(string $linkedType, int $linkedId, array $options, string $kind = null): bool
    {
        $url = $kind ? "/favorites/{$linkedType}/{$linkedId}/{$kind}" : "/favorites/{$linkedType}/{$linkedId}";
        return $this->api->sendRequestWithToken('POST', $url, $options)['status'] === 200;
    }

    public function delete(string $linkedType, int $linkedId): bool
    {
        return $this->api->sendRequestWithToken('DELETE', "/favorites/{$linkedType}/{$linkedId}")['status'] === 200;
    }

    public function reoder(int $id, array $options): bool
    {
        return $this->api->sendRequestWithToken('POST', "/favorites/{$id}/reorder", $options)['status'] === 200;
    }
}
