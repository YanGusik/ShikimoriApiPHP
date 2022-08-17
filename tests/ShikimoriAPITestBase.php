<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ShikimoriAPI\Request;
use ShikimoriAPI\Session;
use ShikimoriAPI\ShikimoriAPI;

abstract class ShikimoriAPITestBase extends TestCase
{
    protected string $accessToken = '1234';

    protected array $header = ['Content-Type' => 'application/json'];
    protected array $headersAuth = [];

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->headersAuth['Content-Type'] = 'application/json';
        $this->headersAuth['Authorization'] = "Bearer " . $this->accessToken;
        parent::__construct($name, $data, $dataName);
    }

    protected function setupStub($expectedMethod, $expectedUri, $expectedParameters, $expectedHeaders, $expectedReturn, $expectsAny = false)
    {
        $stub = $this->createPartialMock(Request::class, ['api', 'getLastResponse']);

        $stub->expects($expectsAny ? $this->any() : $this->once())
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

    protected function setupSessionStub()
    {
        $stub = $this->createPartialMock(Session::class, ['getAccessToken', 'refreshAccessToken']);

        $stub->method('getAccessToken')
            ->willReturn($this->accessToken);

        $stub->method('refreshAccessToken')
            ->willReturn(true);

        return $stub;
    }

    protected function setupApi($expectedMethod, $expectedUri, $expectedParameters, $expectedHeaders, $expectedReturn, $token = null)
    {
        $stub = $this->setupStub(
            $expectedMethod,
            $expectedUri,
            $expectedParameters,
            $expectedHeaders,
            $expectedReturn
        );

        $api = new ShikimoriAPI([], null, $stub);
        if ($token) $api->setAccessToken($token);
        return $api;
    }
}