<?php

/**
 * SensitiveCMS를 실행시키기 위한 파일
 */
use Core\Database;
use Core\Site;
use Core\Router;
use Core\Response;
use Core\Uri;
use Core\Frontend;
use Core\Template;
use Core\Theme as CoreTheme;

class bootloader
{
	protected static $currentSiteInfo;

	/**
	 * 부트로더 초기화
	 */
	public static function init()
	{
		// 모든 오류를 출력한다
		error_reporting(E_ALL);

		// timezone이 설정되지 않은 경우, 서버 환경에 맞는 timezone으로 설정해준다
		date_default_timezone_set(@date_default_timezone_get());

		require dirname(__FILE__) . '/system/constants.php';
		require dirname(__FILE__) . '/system/autoload.php';
		require dirname(__FILE__) . '/system/functions.php';

		// 아직 설치하지 않았다면
		if(!self::isInstalled() && substr(REQUEST_URL, 0, 15) != '_core/_install/')
		{
			// 설치 페이지로 이동한다
			header('Location: ' . BASEURL . '_core/_install/');
			exit;
		}

		// error handle을 bootloader에서 하도록 한다
		set_error_handler('bootloader::errorHandler');
		// exception handle을 bootloader에서 하도록 한다
		set_exception_handler('bootloader::exceptionHandler');

		$dbInfo = config('database');

		Database::connect($dbInfo['hostname'], $dbInfo['username'], $dbInfo['password'], $dbInfo['database'], $dbInfo['port']);

		self::$currentSiteInfo = Site::findSite($_SERVER['HTTP_HOST'], REQUEST_URL);
		if(self::$currentSiteInfo === NULL)
		{
			self::$currentSiteInfo = Site::getDefaultSite();
			if(self::$currentSiteInfo === NULL)
			{
				header('HTTP/1.1 404 Not Found');
				Response::notFound();
				exit();
			}
		}

		// 라우터를 초기화한다
		Router::init();

		// 세션을 시작한다
		session_start();

		// 기본 FrontEnd 구성요소를 불러들인다
		Frontend::addCss('/assets/css/sensitive.css');
		Frontend::addCss('/common/css/semantic.min.css');
		Frontend::addJs('/common/js/jquery-1.12.0.min.js');
		Frontend::addJs('/common/js/semantic.min.js');
		Frontend::addJs('/assets/js/sensitive.js');

		$path = Uri::getCurrentUri();
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
				header('HTTP/1.1 404 Not Found');
				Response::notFound();
				exit;
			}
		}
		else
		{
			// 기본 페이지로 이동
			$db = \Core\Database::getConnection();
			$result = $db->query('SELECT * FROM `st_instances` WHERE `isDefault` = "Y"');
			$obj = $result->fetch_object();

			header('HTTP/1.0 301 Moved Permanently');
			header('Location: ' . BASEURL . $obj->id);
			exit();
		}
	}

	/**
	 * 설치가 되었는지 확인
	 *
	 * @return boolean
	 */
	public static function isInstalled()
	{
		// config 파일이 없다면 false
		if(!file_exists(COREDIR . 'system/config.php'))
		{
			return FALSE;
		}

		// db 설정 파일이 없다면 false
		if(!file_exists(BASEDIR . 'files/config/database.php'))
		{
			return FALSE;
		}

		return TRUE;
	}


	public static function errorHandler($errno, $errstr, $errfile, $errline)
	{
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
	}

	public static function exceptionHandler($e)
	{
		\Core\Response::error($e->getMessage());
	}

	public static function getCurrentSiteInfo()
	{
		return self::$currentSiteInfo;
	}
}

bootloader::init();

register_shutdown_function(function() {
	session_write_close();
});
