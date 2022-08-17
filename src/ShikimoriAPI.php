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

    /**
     * @param array $options
     * @param Session|null $session
     * @param Request|null $request
     */
    public function __construct(array $options = [], Session $session = null, Request $request = null)
    {
        $this->setOptions($options);
        $this->setSession($session);

        $this->request = $request ?? new Request();
    }

    /**
     * @return array
     */
    public function getLastResponse(): array
    {
        return $this->lastResponse;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param $options
     * @return void
     */
    public function setOptions($options): void
    {
        $this->options = array_merge($this->options, (array)$options);
    }

    /**
     * @param $session
     * @return void
     */
    public function setSession($session): void
    {
        $this->session = $session;
    }

    /**
     * @param $accessToken
     * @return void
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @param array $headers
     * @return array
     * @throws ShikimoriAPIException
     */
    protected function authHeaders(array $headers = []): array
    {
        $accessToken = $this->session ? $this->session->getAccessToken() : $this->accessToken;

        if ($accessToken) {
            return $headers = array_merge($headers, [
                'Authorization' => 'Bearer ' . $accessToken,
            ]);
        }

        throw new ShikimoriAPIException('Access token is empty');
    }

    /**
     * @param $method
     * @param $uri
     * @param $parameters
     * @param $headers
     * @param $json
     * @param $withToken
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function sendRequest($method, $uri, $parameters = [], $headers = [], $json = true, $withToken = false): array
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
            if ($withToken) {
                $headers = $this->authHeaders($headers);
            }

            return $lastResponse = $this->request->api($method, $uri, $parameters, $headers);
        } catch (ShikimoriAPIException $exception) {
            if ($withToken && $this->options['auto_refresh'] && $exception->hasExpiredToken()) {
                if ($this->session == null) {
                    throw new ShikimoriAPIException('You need use Session in ShikimoriAPI for auto_refresh');
                }

                $result = $this->session->refreshAccessToken();
                if (!$result) {
                    throw new ShikimoriAPIException('Could not refresh access token.');
                }

                return $this->sendRequest($method, $uri, $parameters, $headers, $withToken);
            } elseif ($this->options['auto_retry'] && $exception->isRateLimited()) {
                sleep($this->options['retry_after']);
                return $this->sendRequest($method, $uri, $parameters, $headers, $withToken);
            }

            throw $exception;
        }
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
     * @throws ShikimoriAPIValidationException
     */
    public function sendRequestWithToken($method, $uri, $parameters = [], $headers = [], $json = true): array
    {
        return $this->sendRequest($method, $uri, $parameters, $headers, $json, true);
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
     * @throws ShikimoriAPIValidationException
     */
    public function sendRequestWithoutToken($method, $uri, $parameters = [], $headers = [], $json = true): array
    {
        return $this->sendRequest($method, $uri, $parameters, $headers, $json);
    }

    /**
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function whoami(): array
    {
        return $this->sendRequestWithToken('GET', '/users/whoami')['body'];
    }
}
