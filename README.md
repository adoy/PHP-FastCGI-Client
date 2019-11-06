# PHP FastCGI Client

[![License](https://poser.pugx.org/adoy/fastcgi-client/license)](https://packagist.org/packages/adoy/fastcgi-client)
[![Latest Stable Version](https://poser.pugx.org/adoy/fastcgi-client/v/stable)](https://packagist.org/packages/adoy/fastcgi-client)
[![Total Downloads](https://poser.pugx.org/adoy/fastcgi-client/downloads)](https://packagist.org/packages/adoy/fastcgi-client)

*PHP FastCGI Client* is a lightweight single file **FastCGI** client for PHP.

## How can I use it ?

```php
<?php

require 'vendor/autoload.php';

use Adoy\FastCGI\Client;

// Existing socket, such as Lighttpd with mod_fastcgi:
$client = new Client('unix:///path/to/php/socket', -1);

// Fastcgi server, such as PHP-FPM:
$client = new Client('localhost', '9000');
$content = 'key=value';
echo $client->request(
	array(
		'GATEWAY_INTERFACE' => 'FastCGI/1.0',
		'REQUEST_METHOD' => 'POST',
		'SCRIPT_FILENAME' => 'test.php',
		'SERVER_SOFTWARE' => 'php/fcgiclient',
		'REMOTE_ADDR' => '127.0.0.1',
		'REMOTE_PORT' => '9985',
		'SERVER_ADDR' => '127.0.0.1',
		'SERVER_PORT' => '80',
		'SERVER_NAME' => 'mag-tured',
		'SERVER_PROTOCOL' => 'HTTP/1.1',
		'CONTENT_TYPE' => 'application/x-www-form-urlencoded',
		'CONTENT_LENGTH' => strlen($content)
	),
	$content
);
```

## Command line tool

Run a call through a network socket:

```
./fcgiget.php localhost:9000/status
```

Run a call through a Unix Domain Socket

```
./fcgiget.php unix:/var/run/php-fpm/web.sock/status
```

> **Note:** This command line tool is provided for debuging purpose.

## Authors

* _**[Pierrick Charron](https://github.com/adoy)** (pierrick@php.net) - Initial work_
* _**[Remi Collet](https://github.com/remicollet)**_

## License

This project is licensed under the MIT License - for the full copyright and license information, please view the [LICENSE](LICENSE) file that was distributed with this source code.

---
_Copyrights 2010-2019 Pierrick Charron Inc. All rights reserved._
