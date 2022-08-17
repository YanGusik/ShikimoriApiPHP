<?php /** @noinspection ALL */

namespace Tests\Resources;

use ShikimoriAPI\Resources\Animes;
use Tests\ShikimoriAPITestBase;

class AnimesTest extends ShikimoriAPITestBase
{
    public function testRoles()
    {
        $id = 1;

        $return = ['body' => get_fixture('roles')];

        $api = $this->setupApi(
            'GET',
            "/animes/$id/roles",
            [],
            $this->header,
            $return
        );

        $response = (new Animes($api))->roles($id);

        $this->assertEquals(147, count($response));
    }

    public function testTopics()
    {
        $id = 1;
        $expected_id = 270101;

        $return = ['body' => get_fixture('topics')];

        $api = $this->setupApi(
            'GET',
            "/animes/$id/topics",
            [],
            $this->header,
            $return
        );

        $response = (new Animes($api))->topics($id);

        $this->assertEquals($expected_id, $response[0]['id']);
    }

    public function testSimilar()
    {
        $id = 1;
        $expected_id = 4;

        $return = ['body' => get_fixture('similar')];

        $api = $this->setupApi(
            'GET',
            "/animes/$id/similar",
            [],
            $this->header,
            $return
        );

        $response = (new Animes($api))->similar($id);

        $this->assertEquals($expected_id, $response[0]['id']);
    }

    public function testGetAll()
    {
        $options = ['order' => 'popularity', 'status' => 'latest', 'limit' => 50];

        $expected = [
            "id" => 1069,
            "name" => "Chou Denji Machine Voltes V",
        ];

        $return = ['body' => get_fixture('animes')];

        $api = $this->setupApi(
            'GET',
            '/animes',
            $options,
            $this->header,
            $return
        );

        $response = (new Animes($api))->getAll($options);

        $this->assertEquals($expected['id'], $response[0]['id']);
        $this->assertEquals($expected['name'], $response[0]['name']);
    }

    public function testGet()
    {
        $expected = [
            "id" => 30276,
            "name" => "One Punch Man",
            "russian" => "Ванпанчмен",
        ];

        $return = ['body' => get_fixture('anime')];

        $api = $this->setupApi(
            'GET',
            "/animes/{$expected['id']}",
            [],
            $this->header,
            $return
        );

        $response = (new Animes($api))->get($expected['id']);

        $this->assertEquals($expected['id'], $response['id']);
        $this->assertEquals($expected['name'], $response['name']);
        $this->assertEquals($expected['russian'], $response['russian']);
    }

    public function testExternalLinks()
    {
        $id = 1;

        $return = ['body' => get_fixture('external_links')];

        $api = $this->setupApi(
            'GET',
            "/animes/$id/external_links",
            [],
            $this->header,
            $return
        );

        $response = (new Animes($api))->externalLinks($id);

        $this->assertEquals(10, count($response));
    }

    public function testReleated()
    {
        $id = 1;

        $return = ['body' => get_fixture('related')];

        $api = $this->setupApi(
            'GET',
            "/animes/$id/related",
            [],
            $this->header,
            $return
        );

        $response = (new Animes($api))->related($id);

        $this->assertEquals(6, count($response));
    }

    public function testScreenshots()
    {
        $id = 1;

        $return = ['body' => get_fixture('screenshots')];

        $api = $this->setupApi(
            'GET',
            "/animes/$id/screenshots",
            [],
            $this->header,
            $return
        );

        $response = (new Animes($api))->screenshots($id);

        $this->assertEquals(35, count($response));
    }
}
