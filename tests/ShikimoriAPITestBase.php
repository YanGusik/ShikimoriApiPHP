<?php

namespace Tests;

use ShikimoriAPI\ShikimoriAPI;
use ShikimoriAPI\Session;
use ShikimoriAPI\Request;

abstract class ShikimoriAPITestBase extends \PHPUnit\Framework\TestCase
{
    protected string $accessToken = 'default';

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

    protected function setupApi($expectedMethod, $expectedUri, $expectedParameters, $expectedHeaders, $expectedReturn)
    {
        $stub = $this->setupStub(
            $expectedMethod,
            $expectedUri,
            $expectedParameters,
            $expectedHeaders,
            $expectedReturn
        );

        return new ShikimoriAPI([], null, $stub);
    }
}