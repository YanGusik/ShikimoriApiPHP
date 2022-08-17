<?php

declare(strict_types=1);

namespace ShikimoriAPI\Resources;

use ShikimoriAPI\ShikimoriAPI;
use ShikimoriAPI\ShikimoriAPIAuthException;
use ShikimoriAPI\ShikimoriAPIException;
use ShikimoriAPI\ShikimoriAPINotFoundException;
use ShikimoriAPI\ShikimoriAPIValidationException;

class Favorites
{
    private ShikimoriAPI $api;

    public function __construct(ShikimoriAPI $api)
    {
        $this->api = $api;
    }

    /**
     * @param string $linkedType
     * @param int $linkedId
     * @param array $options
     * @param string|null $kind
     * @return bool
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function create(string $linkedType, int $linkedId, array $options, string $kind = null): bool
    {
        $url = $kind ? "/favorites/$linkedType/$linkedId/$kind" : "/favorites/$linkedType/$linkedId";
        return $this->api->sendRequestWithToken('POST', $url, $options)['status'] === 200;
    }

    /**
     * @param string $linkedType
     * @param int $linkedId
     * @return bool
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function delete(string $linkedType, int $linkedId): bool
    {
        return $this->api->sendRequestWithToken('DELETE', "/favorites/$linkedType/$linkedId")['status'] === 200;
    }

    /**
     * @param int $id
     * @param array $options
     * @return bool
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function reoder(int $id, array $options): bool
    {
        return $this->api->sendRequestWithToken('POST', "/favorites/$id/reorder", $options)['status'] === 200;
    }
}
