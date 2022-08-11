<?php

namespace Resources;

use ShikimoriAPI\Resources\Animes;
use Tests\ShikimoriAPITestBase;

class AnimesTest extends ShikimoriAPITestBase
{
    private $header = ['Content-Type' => 'application/json'];

    public function testRoles()
    {

    }

    public function testTopics()
    {

    }

    public function testSimilar()
    {

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
    }

    public function testExternalLinks()
    {

    }

    public function testReleated()
    {

    }

    public function testScreenshots()
    {

    }
}
