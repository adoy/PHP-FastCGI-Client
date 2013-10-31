#!/usr/bin/php
<?php
/**
 * Note : Code is released under the GNU LGPL
 *
 * Please do not change the header of this file
 *
 * This library is free software; you can redistribute it and/or modify it under the terms of the GNU
 * Lesser General Public License as published by the Free Software Foundation; either version 2 of
 * the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * See the GNU Lesser General Public License for more details.
 */

require 'src/Adoy/FastCGI/Client.php';

use Adoy\FastCGI\Client;

/**
 * Simple command line script to test communication with a FastCGI server
 *
 * @author      Pierrick Charron <pierrick@webstart.fr>
 * @author      Remi Collet <remi@famillecollet.com>
 * @version     1.0
 */
if (!isset($_SERVER['argc'])) {
    die("Command line only\n");
}
if ($_SERVER['argc']<2) {
    die("Usage: ".$_SERVER['argv'][0]."  URI\n\nEx: ".$_SERVER['argv'][0]." localhost:9000/status\n");
}

$url = parse_url($_SERVER['argv'][1]);
if (!$url || !isset($url['path'])) {
    die("Malformed URI");
}

$req = '/'.basename($url['path']);
if (isset($url['query'])) {
    $uri = $req .'?'.$url['query'];
} else {
    $url['query'] = '';
    $uri = $req;
}
$client = new Client(
    (isset($url['host']) ? $url['host'] : 'localhost'),
    (isset($url['port']) ? $url['port'] : 9000));

$params = array(
		'GATEWAY_INTERFACE' => 'FastCGI/1.0',
		'REQUEST_METHOD'    => 'GET',
		'SCRIPT_FILENAME'   => $url['path'],
		'SCRIPT_NAME'       => $req,
		'QUERY_STRING'      => $url['query'],
		'REQUEST_URI'       => $uri,
		'DOCUMENT_URI'      => $req,
		'SERVER_SOFTWARE'   => 'php/fcgiclient',
		'REMOTE_ADDR'       => '127.0.0.1',
		'REMOTE_PORT'       => '9985',
		'SERVER_ADDR'       => '127.0.0.1',
		'SERVER_PORT'       => '80',
		'SERVER_NAME'       => php_uname('n'),
		'SERVER_PROTOCOL'   => 'HTTP/1.1',
		'CONTENT_TYPE'      => '',
		'CONTENT_LENGTH'    => 0
);
//print_r($params);
echo "Call: $uri\n\n";
echo $client->request($params, false)."\n";

