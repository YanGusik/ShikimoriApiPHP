<?php /** @noinspection ALL */

namespace Tests\Resources;

use ShikimoriAPI\Resources\Characters;
use Tests\ShikimoriAPITestBase;

class CharactersTest extends ShikimoriAPITestBase
{
    public function testGet()
    {
        $id = 1;
        $return = ['body' => get_fixture('character')];
        $api = $this->setupApi(
            'GET',
            "/characters/$id",
            [],
            $this->header,
            $return
        );

        $response = (new Characters($api))->get($id);

        $this->assertEquals($return['body'], $response);
    }

    public function testSearch()
    {
        $search = "hello";
        $return = ['body' => get_fixture('characters')];
        $api = $this->setupApi(
            'GET',
            "/characters/search?search=$search",
            [],
            $this->header,
            $return
        );

        $response = (new Characters($api))->search($search);

        $this->assertEquals($return['body'], $response);
    }
}
