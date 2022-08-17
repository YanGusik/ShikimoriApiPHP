<?php /** @noinspection ALL */

namespace Tests\Resources;

use ShikimoriAPI\Resources\Bans;
use ShikimoriAPI\ShikimoriAPIAuthException;
use ShikimoriAPI\ShikimoriAPIException;
use ShikimoriAPI\ShikimoriAPINotFoundException;
use Tests\ShikimoriAPITestBase;

class BansTest extends ShikimoriAPITestBase
{
    /**
     * @throws ShikimoriAPIException
     * @throws ShikimoriAPIAuthException
     * @throws ShikimoriAPINotFoundException
     */
    public function testBans()
    {
        $return = ['body' => get_fixture('bans')];

        $api = $this->setupApi(
            'GET',
            '/bans',
            [],
            $this->header,
            $return
        );

        $response = (new Bans($api))->bans();

        $this->assertEquals(2, count($response));
    }
}
