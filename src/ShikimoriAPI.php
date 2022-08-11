<?php

declare(strict_types=1);

namespace ShikimoriAPI;

class ShikimoriAPI
{
    protected string $accessToken = '';
    protected array $lastResponse = [];
    protected array $options = [
        'auto_refresh' => false,
        'auto_retry' => false,
        'return_assoc' => true,
        'retry_after' => 3,
    ];
    protected Request $request;
    protected ?Session $session = null;

    public function __construct($options = [], $session = null, $request = null)
    {
        $this->setOptions($options);
        $this->setSession($session);

        $this->request = $request ?? new Request();
    }

    public function setOptions($options): void
    {
        $this->options = array_merge($this->options, (array)$options);
    }

    public function setSession($session): void
    {
        $this->session = $session;
    }

    public function whoami(): array
    {
        return $this->sendRequestWithToken('GET', '/users/whoami')['body'];
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @param $method
     * @param $uri
     * @param $parameters
     * @param $headers
     * @param $json
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     */
    public function sendRequestWithToken($method, $uri, $parameters = [], $headers = [], $json = true)
    {
        $this->request->setOptions([
            'return_assoc' => $this->options['return_assoc'],
        ]);

        if ($json) {
            $headers = array_merge($headers, [
                'Content-Type' => 'application/json',
            ]);
        }

        try {
            $headers = $this->authHeaders($headers);

            return $lastResponse = $this->request->api($method, $uri, $parameters, $headers);
        } catch (ShikimoriAPIException $e) {
            if ($this->options['auto_refresh'] && $e->hasExpiredToken()) {
                if ($this->session == null) {
                    throw new ShikimoriAPIException('You need use Session in ShikimoriAPI for auto_refresh');
                }

                $result = $this->session->refreshAccessToken();
                if (!$result) {
                    throw new ShikimoriAPIException('Could not refresh access token.');
                }

                return $this->sendRequestWithToken($method, $uri, $parameters, $headers);
            } elseif ($this->options['auto_retry'] && $e->isRateLimited()) {
                $lastResponse = $this->request->getLastResponse();
                $retryAfter = $this->options['retry_after'];

                sleep($retryAfter);

                return $this->sendRequestWithToken($method, $uri, $parameters, $headers);
            }

            throw $e;
        }
    }

    protected function authHeaders($headers = [])
    {
        $accessToken = $this->session ? $this->session->getAccessToken() : $this->accessToken;

        if ($accessToken) {
            $headers = array_merge($headers, [
                'Authorization' => 'Bearer ' . $accessToken,
            ]);
        }

        return $headers;
    }

    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * @param $method
     * @param $uri
     * @param $parameters
     * @param $headers
     * @param $json
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     */
    public function sendRequestWithoutToken($method, $uri, $parameters = [], $headers = [], $json = true): array
    {
        $this->request->setOptions([
            'return_assoc' => $this->options['return_assoc'],
        ]);

        if ($json) {
            $headers = array_merge($headers, [
                'Content-Type' => 'application/json',
            ]);
        }

        try {
            return $lastResponse = $this->request->api($method, $uri, $parameters, $headers);
        } catch (ShikimoriAPIException $e) {
            if ($this->options['auto_retry'] && $e->isRateLimited()) {
                $lastResponse = $this->request->getLastResponse();
                $retryAfter = $this->options['retry_after'];

                sleep($retryAfter);

                return $this->sendRequestWithoutToken($method, $uri, $parameters, $headers);
            }

            throw $e;
        }
    }
}
