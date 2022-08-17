<?php /** @noinspection ALL */

namespace Tests\Resources;

use ShikimoriAPI\Resources\Comments;
use Tests\ShikimoriAPITestBase;

class CommentsTest extends ShikimoriAPITestBase
{
    public function testGetAll()
    {
        $options = ['commentable_id' => 1, 'commentable_type' => 'User', 'limit' => 50];

        $return = ['body' => get_fixture('comments')];

        $api = $this->setupApi(
            'GET',
            '/comments',
            $options,
            $this->headersAuth,
            $return,
            $this->accessToken
        );

        $response = (new Comments($api))->getAll($options);

        $this->assertEquals(2, count($response));
    }

    public function testGet()
    {
        $expected = [
            "id" => 4,
            "user_id" => 23456793,
        ];

        $return = ['body' => get_fixture('comment')];

        $api = $this->setupApi(
            'GET',
            "/comments/{$expected['id']}",
            [],
            $this->headersAuth,
            $return,
            $this->accessToken
        );

        $response = (new Comments($api))->get($expected['id']);

        $this->assertEquals($expected['id'], $response['id']);
        $this->assertEquals($expected['user_id'], $response['user_id']);
    }

    public function testCreate()
    {
        $options = [
            'comment' =>
            [
                'body' => 'Hello',
                'commentable_id' => 11,
                'commentable_type' => 'User',
            ]
        ];

        $return = ['status' => 200];

        $api = $this->setupApi(
            'POST',
            '/comments',
            $options,
            $this->headersAuth,
            $return,
            $this->accessToken
        );

        $response = (new Comments($api))->create($options);

        $this->assertTrue($response);
    }

    public function testUpdate()
    {
        $expected = [
            "id" => 4,
            "user_id" => 23456793,
        ];

        $options = [
            'comment' =>
                [
                    'body' => 'Hello'
                ]
        ];

        $return = ['body' => get_fixture('comment')];

        $api = $this->setupApi(
            'PUT',
            "/comments/{$expected['id']}",
            $options,
            $this->headersAuth,
            $return,
            $this->accessToken
        );

        $response = (new Comments($api))->update($expected['id'], $options);

        $this->assertEquals($expected['id'], $response['id']);
        $this->assertEquals($expected['user_id'], $response['user_id']);
    }

    public function testDelete()
    {
        $id = 1;

        $return = ['status' => 200];

        $api = $this->setupApi(
            'DELETE',
            "/comments/$id",
            [],
            $this->headersAuth,
            $return,
            $this->accessToken
        );

        $response = (new Comments($api))->delete($id);

        $this->assertTrue($response);
    }
}
