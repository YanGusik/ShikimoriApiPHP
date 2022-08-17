<?php /** @noinspection ALL */

namespace Tests\Resources;

use ShikimoriAPI\Resources\Clubs;
use Tests\ShikimoriAPITestBase;

class ClubsTest extends ShikimoriAPITestBase
{
    public function testGetAll()
    {
        $options = ['limit' => 50];

        $expected = [
            "id" => 2,
            "name" => "club_2",
        ];

        $return = ['body' => get_fixture('clubs')];

        $api = $this->setupApi(
            'GET',
            '/clubs',
            $options,
            $this->header,
            $return
        );

        $response = (new Clubs($api))->getAll($options);

        $this->assertEquals($expected['id'], $response[0]['id']);
        $this->assertEquals($expected['name'], $response[0]['name']);
    }

    public function testGet()
    {
        $expected = [
            "id" => 1096,
            "name" => "club_7",
        ];

        $return = ['body' => get_fixture('club')];

        $api = $this->setupApi(
            'GET',
            "/clubs/{$expected['id']}",
            [],
            $this->header,
            $return
        );

        $response = (new Clubs($api))->get($expected['id']);

        $this->assertEquals($expected['id'], $response['id']);
        $this->assertEquals($expected['name'], $response['name']);
    }

    public function testAnimes()
    {
        $id = 1;

        $return = ['body' => get_fixture('animes')];

        $api = $this->setupApi(
            'GET',
            "/clubs/$id/animes",
            [],
            $this->header,
            $return
        );

        $response = (new Clubs($api))->animes($id);

        $this->assertEquals(50, count($response));
    }

    public function testMangas()
    {
        $id = 1;

        $return = ['body' => get_fixture('mangas')];

        $api = $this->setupApi(
            'GET',
            "/clubs/$id/mangas",
            [],
            $this->header,
            $return
        );

        $response = (new Clubs($api))->mangas($id);

        $this->assertEquals(1, count($response));
    }

    public function testRanobes()
    {
        $id = 1;

        $return = ['body' => get_fixture('ranobes')];

        $api = $this->setupApi(
            'GET',
            "/clubs/$id/ranobe",
            [],
            $this->header,
            $return
        );

        $response = (new Clubs($api))->ranobe($id);

        $this->assertEquals(1, count($response));
    }

    public function testCharacters()
    {
        $id = 1;

        $return = ['body' => get_fixture('characters')];

        $api = $this->setupApi(
            'GET',
            "/clubs/$id/characters",
            [],
            $this->header,
            $return
        );

        $response = (new Clubs($api))->characters($id);

        $this->assertEquals(1, count($response));
    }

    public function testMembers()
    {
        $id = 1;

        $return = ['body' => get_fixture('members')];

        $api = $this->setupApi(
            'GET',
            "/clubs/$id/members",
            [],
            $this->header,
            $return
        );

        $response = (new Clubs($api))->members($id);

        $this->assertEquals(1, count($response));
    }

    public function testImages()
    {
        $id = 1;

        $return = ['body' => get_fixture('images')];

        $api = $this->setupApi(
            'GET',
            "/clubs/$id/images",
            [],
            $this->header,
            $return
        );

        $response = (new Clubs($api))->images($id);

        $this->assertEquals(1, count($response));
    }

    public function testJoin()
    {
        $id = 1;

        $return = ['status' => 200];

        $api = $this->setupApi(
            'POST',
            "/clubs/$id/join",
            [],
            $this->headersAuth,
            $return,
            $this->accessToken
        );

        $response = (new Clubs($api))->join($id);

        $this->assertTrue($response);
    }

    public function testLeave()
    {
        $id = 1;

        $return = ['status' => 200];

        $api = $this->setupApi(
            'POST',
            "/clubs/$id/leave",
            [],
            $this->headersAuth,
            $return,
            $this->accessToken
        );

        $response = (new Clubs($api))->leave($id);

        $this->assertTrue($response);
    }
}
