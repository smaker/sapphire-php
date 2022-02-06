<?php

$_SERVER['HTTPS'] = 'on';
$_SERVER['HTTP_HOST'] = 'simplecms.io';
$_SERVER['SERVER_NAME'] = 'simplecms.io';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__DIR__));
$_SERVER['SCRIPT_FILENAME'] = dirname(__DIR__) . '/index.php';
$_SERVER['SCRIPT_NAME'] = '/simplecms/index.php';
$_SERVER['REQUEST_URI'] = '/simplecms/index.php';

require dirname(__FILE__) . '/_core/bootloader.php';