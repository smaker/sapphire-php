<?php
namespace Core;

class Uri
{
	public static function getCurrentUri()
	{
		$path = '';

		$uri = $_SERVER['REQUEST_URI'];
		if (stripos($uri, $_SERVER['SCRIPT_NAME']) === 0)
		{
			$uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
		}
		elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0)
		{
			$uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
		}

		if ($uri == '/' || empty($uri))
		{
		}
		else
		{
			$path = parse_url($uri, PHP_URL_PATH);

			// Do some final cleaning of the URI and return it
			$path = str_replace(array('//', '../'), '/', trim($path, '/'));
		}

		return $path;
	}

	public static function get($n)
	{
		$uri = self::getCurrentUri();
		$parts = explode('/', $uri);
		return isset($parts[$n]) ? $parts[$n] : NULL;
	}
}