# Concrete5 HTTP2 Server Push
[![Latest Version on Packagist](https://img.shields.io/packagist/v/xanweb/c5-http2-server-push.svg?maxAge=2592000&style=flat-square)](https://packagist.org/packages/xanweb/c5-http2-server-push)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

Middleware library for Concrete5 to use HTTP/2 pushes

## Installation

Include library to your composer.json
```bash
composer require xanweb/c5-http2-server-push
```

Add the service provider and middleware to `application/config/app.php` :
```php
return [
    'providers' => [
        'xw_http2_server_push' => '\Xanweb\ServerPush\ServiceProvider'
    ],
    'middleware' => [
        'xw_http2_server_push' => '\Xanweb\ServerPush\Middleware\Http2ServerPushMiddleware'
    ]
];
```

Make sure you are loading vendor autoload `application/bootstrap/autoload.php`
```php
<?php

defined('C5_EXECUTE') or die('Access Denied.');

/*
 * ----------------------------------------------------------------------------
 * Load all composer autoload items.
 * ----------------------------------------------------------------------------
 */

// If the checker class is already provided, likely we have been included in a separate composer project
if (!class_exists(\DoctrineXml\Checker::class)) {
    // Otherwise, lets try to load composer ourselves
    if (!@include(DIR_BASE_CORE . '/' . DIRNAME_VENDOR . '/autoload.php')) {
        echo 'Third party libraries not installed. Make sure that composer has required libraries in the concrete/ directory.';
        die(1);
    }
}

if (file_exists(DIR_BASE . '/' . DIRNAME_VENDOR . '/autoload.php')) {
    include_once (DIR_BASE . '/' . DIRNAME_VENDOR . '/autoload.php');
}
```

## Usage
````php
    // Example with Font Preload
    $link = (new \Xanweb\ServerPush\Link('preload', '/path/to/font.woff2'))
                ->withAttribute('as', 'font')
                ->withAttribute('type', 'font/woff2')
                ->withAttribute('crossorigin', 'anonymous');

    app('http2/server-push')->queueLink($link);
````
