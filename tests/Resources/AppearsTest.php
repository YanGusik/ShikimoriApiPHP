<?php

namespace Tests\Resources;

use ShikimoriAPI\Resources\Appear;
use Tests\ShikimoriAPITestBase;

class AppearsTest extends ShikimoriAPITestBase
{
    public function testAppears()
    {
        $comments_ids = [1, 2, 3, 4];

        $api = $this->setupApi(
            'POST',
            '/appears',
            ['ids' => '1,2,3,4'],
            $this->headersAuth,
            ['status' => 200],
            $this->accessToken
        );

        $response = (new Appear($api))->appears($comments_ids);

        $this->assertTrue($response);
    }
}
