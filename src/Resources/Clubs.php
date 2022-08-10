<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;

class Clubs
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    public function getAll(array $options): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/clubs', $options)['body'];
    }

    public function get(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/clubs/' . $id)['body'];
    }

    public function update(int $id, array $options): array
    {
        return $this->api->sendRequestWithToken('PUT', '/clubs/' . $id, $options)['body'];
    }

    public function animes(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/clubs/' . $id . '/animes')['body'];
    }

    public function mangas(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/clubs/' . $id . '/mangas')['body'];
    }

    public function ranobe(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/clubs/' . $id . '/ranobe')['body'];
    }

    public function characters(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/clubs/' . $id . '/characters')['body'];
    }

    public function members(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/clubs/' . $id . '/members')['body'];
    }

    public function images(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/clubs/' . $id . '/images')['body'];
    }

    public function join(int $id): bool
    {
        return $this->api->sendRequestWithToken('POST', '/clubs/' . $id . '/join')['status'] === 200;
    }

    public function leave(int $id): bool
    {
        return $this->api->sendRequestWithToken('POST', '/clubs/' . $id . '/leave')['status'] === 200;
    }
}
