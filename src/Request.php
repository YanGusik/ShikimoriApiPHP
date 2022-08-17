<?php

declare(strict_types=1);

namespace ShikimoriAPI;

class Request
{
    public const API_URL = "https://shikimori.one/api";
    public const OAUTH_AUTHORIZE_URL = "https://shikimori.one/oauth/authorize";
    public const OAUTH_TOKEN_URL = "https://shikimori.one/oauth/token";

    protected array $lastResponse = [];
    protected array $options = [
        'curl_options' => [],
        'return_assoc' => false,
    ];

    public function __construct($options = [])
    {
        $this->setOptions($options);
    }


    /**
     * @param $method
     * @param $uri
     * @param $parameters
     * @param $headers
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function api($method, $uri, $parameters = [], $headers = []): array
    {
        return $this->send($method, self::API_URL . $uri, $parameters, $headers);
    }

    /**
     * @param $method
     * @param $url
     * @param $parameters
     * @param $headers
     * @return array
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    public function send($method, $url, $parameters = [], $headers = []): array
    {
        // Reset any old responses
        $this->lastResponse = [];

        // Sometimes a stringified JSON object is passed
        if (is_array($parameters) || is_object($parameters)) {
            $parameters = http_build_query($parameters, '', '&');
        }

        $options = [
            CURLOPT_CAINFO => __DIR__ . '/cacert.pem',
            CURLOPT_ENCODING => '',
            CURLOPT_HEADER => true,
            CURLOPT_HTTPHEADER => [],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => rtrim($url, '/'),
        ];

        foreach ($headers as $key => $val) {
            $options[CURLOPT_HTTPHEADER][] = "$key: $val";
        }

        $method = strtoupper($method);

        switch ($method) {
            case 'DELETE': // No break
            case 'PUT':
                $options[CURLOPT_CUSTOMREQUEST] = $method;
                $options[CURLOPT_POSTFIELDS] = $parameters;

                break;
            case 'POST':
                $options[CURLOPT_POST] = true;
                $options[CURLOPT_POSTFIELDS] = $parameters;

                break;
            default:
                $options[CURLOPT_CUSTOMREQUEST] = $method;

                if ($parameters) {
                    $options[CURLOPT_URL] .= '/?' . $parameters;
                }

                break;
        }

        $ch = curl_init();

        curl_setopt_array($ch, array_replace($options, $this->options['curl_options']));

        $response = curl_exec($ch);

        if (curl_error($ch)) {
            $error = curl_error($ch);
            $errno = curl_errno($ch);
            curl_close($ch);

            throw new ShikimoriAPIException('cURL transport error: ' . $errno . ' ' . $error);
        }

        [$headers, $body] = $this->splitResponse($response);

        $parsedBody = json_decode($body, $this->options['return_assoc']);
        $status = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $parsedHeaders = $this->parseHeaders($headers);

        $this->lastResponse = [
            'body' => $parsedBody,
            'headers' => $parsedHeaders,
            'status' => $status,
            'url' => $url,
        ];

        curl_close($ch);

        if ($status >= 400) {
            $this->handleResponseError($body, $status);
        }

        return $this->lastResponse;
    }

    public function getLastResponse(): array
    {
        return $this->lastResponse;
    }

    protected function splitResponse($response): array
    {
        $parts = explode("\r\n\r\n", $response, 3);

        // Skip first set of headers for proxied requests etc.
        if (
            preg_match('/^HTTP\/1.\d 100 Continue/', $parts[0]) ||
            preg_match('/^HTTP\/1.\d 200 Connection established/', $parts[0]) ||
            preg_match('/^HTTP\/1.\d 200 Tunnel established/', $parts[0])
        ) {
            return [
                $parts[1],
                $parts[2],
            ];
        }

        return [
            $parts[0],
            $parts[1],
        ];
    }

    protected function parseHeaders($headers): array
    {
        $headers = str_replace("\r\n", "\n", $headers);
        $headers = explode("\n", $headers);

        array_shift($headers);

        $parsedHeaders = [];
        foreach ($headers as $header) {
            [$key, $value] = explode(':', $header, 2);

            $key = strtolower($key);
            $parsedHeaders[$key] = trim($value);
        }

        return $parsedHeaders;
    }

    /**
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPINotFoundException
     * @throws ShikimoriAPIValidationException
     */
    protected function handleResponseError($body, $status)
    {
        $parsedBody = json_decode($body);

        switch ($status) {
            case 422:
                $exception = new ShikimoriAPIValidationException($parsedBody, $status);
                $exception->setReason($parsedBody);
                throw $exception;
            case 401:
            case 400:
                throw new ShikimoriAPIAuthException($parsedBody->error_description, $status, $parsedBody->error);
            case 404:
                throw new ShikimoriAPINotFoundException("Not found resources", $status, $body);
            case 429:
                throw new ShikimoriAPIException('Retry later', $status);
            default:
                throw new ShikimoriAPIException('An unknown error occurred.', $status, $parsedBody);
        }
    }

    public function setOptions($options): void
    {
        $this->options = array_merge($this->options, (array)$options);
    }
}
