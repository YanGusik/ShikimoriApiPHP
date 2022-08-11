<?php

require_once '../vendor/autoload.php';

use ShikimoriAPI\Resources\Animes;

$animes = new Animes();

$a = $animes->getAll();

$a = array_map(fn($value) => $value['name'], $a);


$session = new \ShikimoriAPI\Session(
  'OmWJ8XPBS95qMmXXsmLDDSz2If9oKD98AYlgmUHSo9s',
  '_4JBBa_i64upY9cqRh2uhAz6lY32YoSVpI5yHfDm4XU',
  'https://127.0.0.1'
);

$api = new ShikimoriAPI\ShikimoriAPI(['auto_refresh' => true], $session);

$b = [];

$session->setAccessToken('8qswAXvojhx-5H2bBGxloG65mhAyDuKo18GlpcQxIrE');
$session->setRefreshToken('6LzJ7G0VHBqjPX1VuUkDxLqfut6mqy1LkKZxNNnKri4');

$b[] = $session->getAccessToken();

$api->setSession($session);

$animesResource = new Animes();

$animes = $animesResource->getAll();


$b[] = $api->whoami();


print_r($b);

