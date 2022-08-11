<?php

declare(strict_types=1);

class ShikimoriAPITest extends PHPUnit\Framework\TestCase
{
    private string $accessToken = 'default';

    private function setupStub($expectedMethod, $expectedUri, $expectedParameters, $expectedHeaders, $expectedReturn)
    {
        $stub = $this->createPartialMock(ShikimoriAPI\Request::class, ['api', 'getLastResponse']);

        $stub->expects($this->any())
            ->method('api')
            ->with(
                $this->equalTo($expectedMethod),
                $this->equalTo($expectedUri),
                $this->equalTo($expectedParameters),
                $this->equalTo($expectedHeaders)
            )
            ->willReturn($expectedReturn);

        $stub->expects($this->any())
            ->method('getLastResponse')
            ->willReturn($expectedReturn);

        return $stub;
    }

    private function setupSessionStub()
    {
        $stub = $this->createPartialMock(ShikimoriAPI\Session::class, ['getAccessToken', 'refreshAccessToken']);

        $stub->method('getAccessToken')
            ->willReturn($this->accessToken);

        $stub->method('refreshAccessToken')
            ->willReturn(true);

        return $stub;
    }

    private function setupApi($expectedMethod, $expectedUri, $expectedParameters, $expectedHeaders, $expectedReturn)
    {
        $stub = $this->setupStub(
            $expectedMethod,
            $expectedUri,
            $expectedParameters,
            $expectedHeaders,
            $expectedReturn
        );

        return new ShikimoriAPI\ShikimoriAPI([], null, $stub);
    }

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
            $return
        );

        $stub->method('api')
            ->will(
                $this->onConsecutiveCalls(
                    $this->throwException(
                        new ShikimoriAPI\ShikimoriAPIException('The access token is invalid', 401)
                    ),
                    $this->returnValue($return)
                )
            );

        $api = new ShikimoriAPI\ShikimoriAPI($options, $sessionStub, $stub);
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
            $return
        );

        $stub->method('api')
            ->will(
                $this->onConsecutiveCalls(
                    $this->throwException(
                        new ShikimoriAPI\ShikimoriAPIException('Retry later', 429)
                    ),
                    $this->returnValue($return)
                )
            );

        $api = new ShikimoriAPI\ShikimoriAPI($options, null, $stub);
        $api->setAccessToken($this->accessToken);

        $response = $api->whoami();

        $this->assertArrayHasKey('id', $response);
    }
}
