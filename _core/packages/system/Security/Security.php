<?php
namespace Core;

class Security
{
	private static $purifier;

	public static function useHTMLPurifier()
	{
		if(!class_exists('HTMLPurifier'))
		{
			require '/path/to/HTMLPurifier.auto.php';
			
			$config = HTMLPurifier_Config::createDefault();
			self::$purifier = new HTMLPurifier($config);
		}
	}

	/**
	 * XSS 공격에 사용될 수 있는 문자열을 걸러내서 return
	 */
	public static function clean($str)
	{
		// HTML entity 치환
		$str = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $str);
		$str = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $str);
		$str = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $str);
		$str = html_entity_decode($str, ENT_COMPAT, 'UTF-8');

		// 모든 HTML 태그 제거
		$str = strip_tags($str);

		// javascript 제한
		$str = str_replace('javascript://', '', $str);

		// vbscript 제한
		$str = str_replace('vbscript://', '', $str);

		return $str;
	}

	/**
	 * 악의적인 공격 가능성이 있는 태그 및 속성을 제거해서 return
	 */
	public static function purifyHTML($html)
	{
		self::useHTMLPurifier();

		return self::$purifier->purify($html);
	}
}