<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;
use ShikimoriAPI\ShikimoriAPIException;
use ShikimoriAPI\ShikimoriAPINotFoundException;

class Mangas
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api = null)
    {
        $this->api = $api ?? new ShikimoriAPI();
    }

    /**
     * @param array $options . Options for manga.
     * - int page*. Between 1 and 100000.
     * - int limit*. Maximum 50
     * - string order*. [id,id_desc,ranked,kind,popularity,name,episodes,status,random,created_at,created_at_desc]
     * - string kind*. [tv, movie, ova, ona, special, music, tv_13, tv_24, tv_48]
     * - string status*. [anons, ongoing, released, latest]
     * - string season*. [summer_2017,2016,2014_2016,199x etc...]
     * - int score*. Minimal anime score
     * - string duration*. [S – less than 10 minutes, D – less than 30 minutes, F – more than 30 minutes] [S,D,F]
     * - string rating*. [none, g, pg, pg_13, r, r_plus, rx]
     * - ids genre*. List of genre ids separated by comma
     * - ids studio*. List of studios ids separated by comma
     * - ids franchise*. List of franchises ids separated by comma
     * - bool censored*. [true, false]
     * - ids ids*. List of anime ids separated by comma
     * - ids exclude_ids*. List of anime ids separated by comma
     * - string search Optional. Search phrase to filter animes by name
     * @return array
     * @throws ShikimoriAPINotFoundException|ShikimoriAPIException
     */
    public function getAll(array $options = ['order' => 'popularity', 'status' => 'latest', 'limit' => 50]): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/mangas', $options)['body'];
    }

    public function get(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/mangas/' . $id)['body'];
    }

    public function roles(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/mangas/' . $id . '/roles')['body'];
    }

    public function similar(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/mangas/' . $id . '/similar')['body'];
    }

    public function releated(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/mangas/' . $id . '/related')['body'];
    }

    public function franchise(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/mangas/' . $id . '/franchise')['body'];
    }

    public function externalLinks(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/mangas/' . $id . '/external_links')['body'];
    }

    public function topics(int $id): array
    {
        return $this->api->sendRequestWithoutToken('GET', '/mangas/' . $id . '/topics')['body'];
    }
}
