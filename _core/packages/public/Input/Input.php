<?php
namespace Core;

/**
 * 사용자의 입력값을 받아서 관리하는 class 입니다
 * @class Input
 */
class Input
{
	/**
	 * $_GET 변수에 있는 값을 가져온다
	 *
	 * @param string $key 키
	 * @param bool $clean 값 정리 여부
	 * @param bool $antixss XSS 코드를 제거할 지 여부
	 */
	public static function get($key, $clean = FALSE, $antixss = FALSE)
	{
		if(isset($_GET[$key]))
		{
			if($antixss)
			{
				return Security::clean($_GET[$key]);
			}

			return $clean ? trim($_GET[$key]) : $_GET[$key];
		}
		   
		return NULL;
	}

	/**
	 * $_POST 변수에 있는 값을 가져온다
	 *
	 * @param string $key 키
	 * @param bool $clean 값 정리 여부
	 * @param bool $antixss XSS 코드를 제거할 지 여부
	 */
	public static function post($key, $clean = FALSE, $antixss = FALSE)
	{
		if(isset($_POST[$key]))
		{
			if($antixss)
			{
				return Security::clean($_POST[$key]);
			}

			return $clean ? trim($_POST[$key]) : $_POST[$key];
		}
		   
		return NULL;
	}

	/**
	 * $_REQUEST 변수에 있는 값을 가져온다
	 *
	 * @param string $key 키
	 * @param bool $clean 값 정리 여부
	 * @param bool $antixss XSS 코드를 제거할 지 여부
	 */
	public static function request($key, $clean = FALSE, $antixss = FALSE)
	{
		if(isset($_REQUEST[$key]))
		{
			if($antixss)
			{
				return Security::clean($_REQUEST[$key]);
			}

			return $clean ? trim($_REQUEST[$key]) : $_REQUEST[$key];
		}

		return NULL;
	}

	/**
	 * $_FILES 변수에 있는 값을 가져온다
	 * 
	 * @param string $key 키
	 */
	public static function file($key)
	{
		return isset($_FIELS[$key]) ? $_FILES[$key] : NULL;
	}
}