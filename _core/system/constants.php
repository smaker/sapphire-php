<?php

// 설치 경로
define('BASEDIR', dirname(__DIR__ . '/../../'));

// 모듈 디렉토리
define('MODULEDIR', BASEDIR . 'modules/');
// 플러그인 디렉토리
define('PLUGINDIR', BASEDIR . 'plugins/');
// 테마 디렉토리
define('THEMEDIR', BASEDIR . 'themes/');

if (isset($_SERVER['DOCUMENT_ROOT']) && !strncmp(BASEDIR,  str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), strlen($_SERVER['DOCUMENT_ROOT'])))
{
	define('BASEURL', rtrim(substr(BASEDIR, strlen($_SERVER['DOCUMENT_ROOT'])), '/') . '/');
}
elseif (isset($_SERVER['PHP_SELF']) && ($len = strlen($_SERVER['PHP_SELF'])) && $len >= 10 && substr($_SERVER['PHP_SELF'], $len - 10) === '/index.php')
{
	define('BASEURL', rtrim(str_replace('\\', '/', substr($_SERVER['PHP_SELF'], 0, $len - 10)), '/') . '/');
}
else
{
	define('BASEURL', '/');
}

if (isset($_SERVER['REQUEST_URI']))
{
	define('REQUEST_URL', BASEURL === '/' ? substr($_SERVER['REQUEST_URI'], 1) : (substr($_SERVER['REQUEST_URI'], strlen(BASEURL)) ?: ''));
}
else
{
	define('REQUEST_URL', '');
}

const SYSTEM_PACKAGES = array(
	'Database',
	'DatabaseConnection',
	'Response',
	'Template',
	'TemplateHandler',
	'Frontend',
	'Router',
	'Uri',
	'Module',
	'Theme',
	'Request',
	'Site'
);
