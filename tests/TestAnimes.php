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

$session->setAccessToken('OK69Zrh8bwZn1f2zoJrswrrj2KBqdYRJnGkbpfnVtQE');
$session->setRefreshToken('W-uzspF4ghV_cqe0-DI6b4yGK9FQofA6-WlSYWPauss');

$b[] = $session->getAccessToken();

$api->setSession($session);

$animesResource = new Animes();

$animes = $animesResource->getAll();


$b[] = $animesResource->releated((int)$animes[0]['id']);


print_r($b);

