<?php

declare(strict_types=1);

namespace ShikimoriAPI;

class Session
{
    protected $accessToken = '';
    protected $clientId = '';
    protected $clientSecret = '';
    protected $expirationTime = 0;
    protected $redirectUri = '';
    protected $refreshToken = '';
    protected $scope = '';
    protected $request = null;

    public function __construct($clientId, $clientSecret = '', $redirectUri = '', $request = null)
    {
        $this->setClientId($clientId);
        $this->setClientSecret($clientSecret);
        $this->setRedirectUri($redirectUri);

        $this->request = $request ?? new Request();
    }


    public function getAuthorizeUrl($options = [])
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

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function getTokenExpiration()
    {
        return $this->expirationTime;
    }

    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    public function getScope()
    {
        return explode(' ', $this->scope);
    }
    //TODO: f
    public function refreshAccessToken($refreshToken = null)
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

        /// Examples
        /// {
        //    "access_token": "bUhseBI4YXzZgH72CxNPqnAVTydJvrHgrKtGOpRDr_Y",
        //    "token_type": "Bearer",
        //    "expires_in": 86400,
        //    "refresh_token": "t8iDpLkCFFCGc_-jFUAyic_fM6uGnj5fBXXOr8XgEM4",
        //    "scope": "user_rates messages comments topics content clubs friends ignores",
        //    "created_at": 1660049446
        //}

        if (isset($response->refresh_token) && isset($response->access_token)) {
            $this->accessToken = $response->access_token;
            $this->expirationTime = time() + $response->expires_in;
            $this->refreshToken = $response->refresh_token;
            $this->scope = $response->scope ?? $this->scope;

            return true;
        }

        return false;
    }

    public function requestCredentialsToken()
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
