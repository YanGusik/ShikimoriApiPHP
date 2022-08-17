<?php

declare(strict_types=1);

namespace ShikimoriAPI;

class Session
{
    protected string $accessToken = '';
    protected string $clientId = '';
    protected string $clientSecret = '';
    protected int $expirationTime = 0;
    protected string $redirectUri = '';
    protected string $refreshToken = '';
    protected string $scope = '';
    protected ?Request $request = null;

    public function __construct($clientId, $clientSecret = '', $redirectUri = '', $request = null)
    {
        $this->setClientId($clientId);
        $this->setClientSecret($clientSecret);
        $this->setRedirectUri($redirectUri);

        $this->request = $request ?? new Request();
    }


    /**
     * @param array $options
     * @return string
     */
    public function getAuthorizeUrl(array $options = []): string
    {
        $options = (array)$options;

        $parameters = [
            'client_id' => $this->getClientId(),
            'redirect_uri' => $this->getRedirectUri(),
            'response_type' => 'code',
            'scope' => isset($options['scope'])
                ? implode(' ', $options['scope'])
                : 'user_rates comments topics'
        ];

        return Request::OAUTH_AUTHORIZE_URL . '?' . http_build_query($parameters, '', '&');
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public function getTokenExpiration(): int
    {
        return $this->expirationTime;
    }

    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getScope(): array
    {
        return explode(' ', $this->scope);
    }

    /**
     * @param $refreshToken
     * @return bool
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function refreshAccessToken($refreshToken = null): bool
    {
        $parameters = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken ?? $this->refreshToken,
        ];

        $headers = [];
        if ($this->getClientSecret()) {
            $payload = base64_encode($this->getClientId() . ':' . $this->getClientSecret());

            $headers = [
                'Authorization' => 'Basic ' . $payload,
            ];
        }

        $response = $this->request->send('POST', Request::OAUTH_TOKEN_URL, $parameters, $headers);
        $response = $response['body'];

        if (isset($response->access_token)) {
            $this->accessToken = $response->access_token;
            $this->expirationTime = time() + $response->expires_in;
            $this->scope = $response->scope ?? $this->scope;

            if (isset($response->refresh_token)) {
                $this->refreshToken = $response->refresh_token;
            } elseif (empty($this->refreshToken)) {
                $this->refreshToken = $refreshToken;
            }

            return true;
        }

        return false;
    }

    /**
     * @param $authorizationCode
     * @return bool
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function requestAccessToken($authorizationCode): bool
    {
        $parameters = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'code' => $authorizationCode,
            'redirect_uri' => $this->getRedirectUri(),
        ];

        $response = $this->request->send('POST', Request::OAUTH_TOKEN_URL, $parameters, []);
        $response = $response['body'];

        if (isset($response->refresh_token) && isset($response->access_token)) {
            $this->accessToken = $response->access_token;
            $this->expirationTime = time() + $response->expires_in;
            $this->refreshToken = $response->refresh_token;
            $this->scope = $response->scope ?? $this->scope;

            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function requestCredentialsToken(): bool
    {
        $payload = base64_encode($this->getClientId() . ':' . $this->getClientSecret());

        $parameters = [
            'grant_type' => 'client_credentials',
        ];

        $headers = [
            'Authorization' => 'Basic ' . $payload,
        ];

        $response = $this->request->account('POST', '/api/token', $parameters, $headers);
        $response = $response['body'];

        if (isset($response->access_token)) {
            $this->accessToken = $response->access_token;
            $this->expirationTime = time() + $response->expires_in;
            $this->scope = $response->scope ?? $this->scope;

            return true;
        }

        return false;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }
}
