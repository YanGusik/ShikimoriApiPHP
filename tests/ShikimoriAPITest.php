<?php

declare(strict_types=1);

namespace Tests;

class ShikimoriAPITest extends ShikimoriAPITestBase
{
    public function testAutoRefreshOption()
    {
        $options = ['auto_refresh' => true];

        $headers = [
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type' => 'application/json'
        ];
        $return = ['body' => ['id' => 1234]];
        $sessionStub = $this->setupSessionStub();
        $stub = $this->setupStub(
            'GET',
            '/users/whoami',
            [],
            $headers,
            $return,
            true
        );

        $stub->method('api')
            ->will(
                $this->onConsecutiveCalls(
                    $this->throwException(
                        new \ShikimoriAPI\ShikimoriAPIException('The access token is invalid', 401)
                    ),
                    $this->returnValue($return)
                )
            );

        $api = new \ShikimoriAPI\ShikimoriAPI($options, $sessionStub, $stub);
        $response = $api->whoami();

        $this->assertArrayHasKey('id', $response);
    }

    public function testAutoRetryOption()
    {
        $options = ['auto_retry' => true];

        $headers = [
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type' => 'application/json'
        ];
        $return = [
            'body' => ['id' => 1234],
            'headers' => [
                'retry-after' => 3,
            ],
            'status' => 429,
        ];

        $stub = $this->setupStub(
            'GET',
            '/users/whoami',
            [],
            $headers,
            $return,
            true
        );

        $stub->method('api')
            ->will(
                $this->onConsecutiveCalls(
                    $this->throwException(
                        new \ShikimoriAPI\ShikimoriAPIException('Retry later', 429)
                    ),
                    $this->returnValue($return)
                )
            );

        $api = new \ShikimoriAPI\ShikimoriAPI($options, null, $stub);
        $api->setAccessToken($this->accessToken);

        $response = $api->whoami();

        $this->assertArrayHasKey('id', $response);
    }
}
