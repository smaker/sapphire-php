<?php

function config($config_item = 'global')
{
	$config = require BASEDIR . 'files/config/' . $config_item . '.php';

	return $config;
}

function escape($str)
{
	return htmlspecialchars($str, ENT_COMPAT | ENT_HTML401, 'UTF-8', FALSE);
}

/**
 * html header를 출력한다
 */
function htmlHeader()
{
	echo "<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset=\"utf-8\">
</head>
<body>";
}

/**
 * html footer를 출력한다
 */
function htmlFooter()
{
	echo "</body>
</html>";
}

/**
 * javascript의 alert을 이용해 경고 메시지를 출력한다
 * @param string $msg 출력할 메시지
 * @param bool $back 이전 페이지로 되돌아갈지 여부
 */
function alertScript($msg, $back = FALSE)
{
	echo '<script>alert("' . addslashes($msg) . '");</script>';
	if($back)
	{
		echo '<script>history.back(-1);</script>';
	}
}

function module($module)
{
	static $modules = array();

	if(isset($modules[$module]))
	{
		return $modules[$module];
	}

	if(is_readable(MODULEDIR . $module . '/@Module.php'))
	{
		try
		{
			require MODULEDIR . $module . '/@Module.php';

			$class = 'Module\\' . $module . '\\Base';
			$moduleObject = new $class;
		}
		catch(Exception $e)
		{
			$moduleObject = new stdClass;
		}
		finally
		{
			$modules[$module] = $moduleObject;
			return $moduleObject;
		}
	}
	else
	{
		return new stdClass;
	}
}

/**
 * 해당 모듈의 package.json 파일을 읽어서 return
 */
function getModuleInfo($module)
{
	$specificModuleDir = MODULEDIR . $module;

	$packageJsonFile = $specificModuleDir . '/package.json';

	if(file_exists($packageJsonFile))
	{
		$moduleInfo = json_decode(file_get_contents($packageJsonFile));
		// package.json 문법이 잘못된 경우
		if($moduleInfo === NULL && json_last_error())
		{
			$moduleInfo = new stdClass;
			/**
			 * @todo development 환경인 경우 warning을 출력한다
			 */
		}

		// package.json에서 기본적으로 제공하는 name과 description은 필요하지 않으므로 제거한다.
		unset($moduleInfo->name);
		unset($moduleInfo->description);

		/**
		 * 모듈 이름과 설명을 가져온다.
		 *
		 * @todo 다국어 지원 시 수정 필요
		 */
		$moduleInfo->title = $moduleInfo->moduleInfo->title->ko;
		$moduleInfo->description = $moduleInfo->moduleInfo->description->ko;

		// 모듈 정보에 모듈 설치 경로를 추가한다
		$moduleInfo->module_dir = $specificModuleDir;

		return new $moduleInfo;
	}

	return new stdClass;
}

function plugin($plugin)
{

}

function instance($id, $siteId = NULL)
{
	return Core\Database::getConnection()->select('*')->from('st_instances')->where(array('id' => $id, 'siteId' => $siteId))->get()->fetch_object();
}

/**
 * 파일 크기를 사람이 인지하기 쉽도록 출력한다
 * @param int $size 파일 크기
 * @return string
 */
function prettyFilesize($size)
{
	if(!$size)
	{
		return '0Byte';
	}
	if($size === 1)
	{
		return '1Byte';
	}
	if($size < 1024)
	{
		return $size . 'Bytes';
	}
	if($size >= 1024 && $size < 1024 * 1024)
	{
		return sprintf("%0.1fKB", $size / 1024);
	}
	return sprintf("%0.2fMB", $size / (1024 * 1024));
}

function convertDateFormat($date, $toFormat = 'Y-m-d')
{
	return date_format(date_create($date), $toFormat);
}

/**
 * 해당 URL을 실제 설치경로에 맞게 변경해준다
 */
function url($url)
{
	if($url{0} == '/')
	{
		$url = substr($url, 1);
	}

	return BASEURL . $url;
}
