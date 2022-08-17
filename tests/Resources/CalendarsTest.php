<?php /** @noinspection ALL */

namespace Tests\Resources;

use ShikimoriAPI\Resources\Calendars;
use Tests\ShikimoriAPITestBase;

class CalendarsTest extends ShikimoriAPITestBase
{
    public function testCalendars()
    {
        $return = ['body' => get_fixture('calendar')];

        $api = $this->setupApi(
            'GET',
            '/calendar?censored=false',
            [],
            $this->header,
            $return
        );

        $response = (new Calendars($api))->calendar(false);

        $this->assertEquals(4, count($response));
    }
}
