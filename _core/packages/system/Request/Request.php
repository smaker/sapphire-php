<?php
namespace Core;

/**
 * @class Request
 *
 * 외부에서 들어온 데이터를 관리하는 패키지
 */
class Request
{
	public static function getRequestUri()
	{
		return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . (in_array($_SERVER['SERVER_PORT'], array(80, 443)) ? '' : ':' . $_SERVER['SERVER_PORT']) . $_SERVER['REQUEST_URI'];
	}
}