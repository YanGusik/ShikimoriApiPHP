<?php /** @noinspection ALL */

namespace Tests\Resources;

use ShikimoriAPI\Resources\Achievements;
use Tests\ShikimoriAPITestBase;

class AchievementsTest extends ShikimoriAPITestBase
{
    public function testAchievements()
    {
        $user_id = 1151494;

        $expected = [
            "id" => 1298721706,
            "neko_id" => "animelist",
            "level" => 1,
            "progress" => 62,
            "user_id" => 1151494,
            "created_at" => "2022-08-08T20:04:32.282+03:00",
            "updated_at" => "2022-08-08T20:43:56.267+03:00"
        ];

        $return = ['body' => get_fixture('achievements')];
        $api = $this->setupApi(
            'GET',
            '/achievements?user_id=1151494',
            [],
            $this->headersAuth,
            $return,
            $this->accessToken
        );

        $response = (new Achievements($api))->achievements($user_id);

        $this->assertEquals($expected, $response[0]);
    }
}
