# Shikimori API PHP
🔌 A PHP wrapper for the http://shikimori.one API

[![Packagist](https://img.shields.io/packagist/v/yangusik/shikimori-api-php.svg)](https://packagist.org/packages/yangusik/shikimori-api-php)
![build](https://github.com/yangusik/shikimori-api-php/workflows/build/badge.svg)
[![Coverage Status](https://coveralls.io/repos/yangusik/shikimori-api-php/badge.svg?branch=main)](https://coveralls.io/r/yangusik/shikimori-api-php?branch=main)

This is a PHP wrapper for [Shikimori Web API](https://shikimori.one/api/doc/1.0). It includes the following:

* Helper methods for all API endpoints
* Authorization Code.
* Automatic refreshing of access tokens.
* Automatic retry of rate limited requests.
* PSR-4 autoloading support.

## Requirements
* PHP 7.4 or later.
* PHP [cURL extension](http://php.net/manual/en/book.curl.php) (Usually included with PHP).

## Installation
Install it using [Composer](https://getcomposer.org/):

```sh
composer require yangusik/shikimori-api-php
```

## Usage
Before using the Shikimori API, you'll need to create an app at [Shikimori app](https://shikimori.one/oauth/applications).

Simple example displaying a user's profile:
```php
require 'vendor/autoload.php';

$session = new ShikimoriAPI\Session(
    'CLIENT_ID',
    'CLIENT_SECRET',
    'REDIRECT_URI'
);

$api = new ShikimoriAPI\ShikimoriAPI();

if (isset($_GET['code'])) {
    $session->requestAccessToken($_GET['code']);
    $api->setAccessToken($session->getAccessToken());

    print_r($api->whoami());
} else {
    $options = [
        'scope' => [
            'user-read-email',
        ],
    ];

    header('Location: ' . $session->getAuthorizeUrl($options));
    die();
}
```

For more instructions and examples, check out the [documentation](/docs/). (soon)

## License
MIT license. Please see [LICENSE.md](LICENSE.md) for more info.