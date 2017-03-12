<?php

/**
 *
 * SensitiveCMS를 실행시키기 위한 파일
 *
 */

// 모든 오류를 출력한다
error_reporting(E_ALL);

// timezone이 설정되지 않은 경우, 서버 환경에 맞는 timezone으로 설정해준다
date_default_timezone_set(@date_default_timezone_get());

/**
 * 설치 경로
 */
define('BASEDIR', str_replace('\\', '/', dirname(__DIR__)) . '/');
/**
 * 코어 디렉토리
 */
define('COREDIR', BASEDIR . '_core/');
/**
 * 모듈 디렉토리
 */
define('MODULEDIR', BASEDIR . 'modules/');
/**
 * 플러그인 디렉토리
 */
define('PLUGINDIR', BASEDIR . 'plugins/');
/**
 * 테마 디렉토리
 */
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

use Core\Router;
use Core\Database;
use Core\Uri;
use Core\Frontend;
use Core\Response;
use Core\Theme as CoreTheme;
use Core\Template;
use Core\Site;

$globalConfigExists = FALSE;
// 먼저 설치가 되어 있는지 확인한다
if(file_exists(BASEDIR . 'files/config/global.php'))
{
	$config = config();
	$globalConfigExists = TRUE;
}
else
{
	$globalConfigExists = FALSE;
}

$dbConfigExists = FALSE;
if(file_exists(BASEDIR . 'files/config/database.php'))
{
	$db = config('database');

	Database::connect($db['hostname'], $db['username'], $db['password'], $db['database'], $db['port']);
	$dbConfigExists = TRUE;
}
else
{

}

// 설정 파일이 없다면
if(!$globalConfigExists && !$dbConfigExists && substr(REQUEST_URL, 0, 15) != '_core/_install/')
{
	header('Location: ' . BASEURL . '_core/_install/');
	exit();
}
set_error_handler(function($errno, $errstr, $errfile, $errline) {
	if(stripos($errstr, 'date_default_timezone_get()') === FALSE)
	{
		$iconClass = '';
		$iconClasses = array(
			E_NOTICE => '',
			E_WARNING => 'warning',
			E_ERROR => 'error',
			E_USER_NOTICE => '',
			E_USER_WARNING => 'warning',
			E_USER_ERROR => 'error'
		);

		if(isset($iconClasses[$errno]))
		{
			$iconClass = $iconClasses[$errno];
		}

		echo '<div class="ui container">
			<div class="ui basic segment">
				<div class="ui icon message ' . $iconClass . '">
					<i class="notched lock icon"></i>
					<div class="content">
						<div class="header">
						PHP Error
						</div>
						<p>위치 : ' . $errfile . ':' . $errline . '<br>오류 : ' . $errstr . '</p>
					</div>
				</div>
			</div>
		</div>';
	}
});

set_exception_handler(function($e) {
	\Core\Response::error($e->getMessage());
});

session_start();

$siteInfo = Site::findSite($_SERVER['HTTP_HOST'], REQUEST_URL);
if($siteInfo === NULL)
{
	$siteInfo = Site::getDefaultSite();
	if($siteInfo === NULL)
	{
		header('HTTP/1.0 404 Not Found');
		Response::notFound();
		exit();
	}
}

$GLOBALS['siteInfo'] = $siteInfo;

// 기본 route를 등록한다
Router::get('^[a-z0-9_]+$', function() {
	global $siteInfo;
	$id = Uri::get(0);

	$instance = instance($id, $siteInfo->siteId);

	if(!isset($instance->id))
	{
		header('HTTP/1.0 404 Not Found');
		Response::notFound();
		exit();
	}

	Frontend::setTitle($instance->title);

	$moduleInfo = module($instance->type);

	$call = 'Module\\' .  ucfirst($instance->type) . '\\View';

	$method = $moduleInfo->defaultViewMethod;

	$module = new $call();
	$module->setModule($instance);
	$module->setTemplatePath($module->getViewPath());

	$view = $module->{$method}();

	// 템플릿 객체 생성
	$template = new Template($view->getTemplateFile(), $view->getTemplateVar());

	$siteTheme = $view->config->siteTheme;

	// 빈 사이트 테마를 사용한다면
	if($siteTheme == '@')
	{
		Response::toHTML($template);
		return TRUE;
	}

	$theme = CoreTheme::getTheme($siteTheme);
	$themeHtml = $theme->render($template);

	Response::toHTML($themeHtml);

	// Continue
	return TRUE;
});

$path = Uri::getCurrentUri();

Frontend::addCss('/assets/css/sensitive.css');
Frontend::addCss('/common/css/semantic.min.css');
Frontend::addJs('/common/js/jquery-1.12.0.min.js');
Frontend::addJs('/common/js/semantic.min.js');
Frontend::addJs('/assets/js/sensitive.js');

if($path)
{
	foreach(scandir(MODULEDIR) as $file)
	{
		if ($file != '.' && $file != '..' && is_dir(MODULEDIR.'/'.$file))
		{
			module($file);
		}
	}

	$route = Router::findRoute();
	if($route)
	{
		if($route == 'fuck')
		{
			Response::error('요청하신 페이지는 아직 개발중인 페이지입니다.');
		}
		else
		{
			$route();
		}
	}

	if($route === FALSE)
	{
		header('HTTP/1.0 404 Not Found');
		Response::notFound();
		exit;
	}
}
else
{
	// 기본 페이지로 이동
	$db = Core\Database::getConnection();
	$result = $db->query('SELECT * FROM `st_instances` WHERE `isDefault` = "Y"');
	$obj = $result->fetch_object();

	header('HTTP/1.0 301 Moved Permanently');
	header('Location: ' . BASEURL . $obj->id);
	exit();
}

register_shutdown_function(function() {
	session_write_close();
});
