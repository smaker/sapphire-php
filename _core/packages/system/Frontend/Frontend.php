<?php
namespace Core;

/**
 * Frontend 파일 및 메타 정보 관리를 위한 class
 * @class Frontend
 * @version 1.0
 *
 * @author SimpleCode <simplecode@sensitivecms.com>
 *
 * @todo meta 정보를 관리할 수 있는 method 추가
 */
class Frontend
{
	/** @var string 브라우저 제목 */
	private static $title;
	/** @var array css 파일 */
	private static $cssFiles = array();
	/** @var array js 파일 */
	private static $jsFiles = array();
	/** @var meta 정보 **/
	private static $meta = array();

	/**
	 * css 파일 추가
	 * @param string $file 파일 경로
	 * @param string $media media 값
	 * @param string $targetie targetie 값
	 * @return void
	 */
	public static function addCss($file = '', $media = 'all', $targetie = '')
	{
		$file = self::_getNormalizedUrl($file);

		self::$cssFiles[$file] = array(
			'media' => $media,
			'targetie' => $targetie
		);
	}

	/**
	 * js 파일 추가
	 * @param string $file 파일 경로
	 * @param string $targetie targetie 값
	 * @return void
	 */
	public static function addJs($file = '', $targetie = '')
	{
		$file = self::_getNormalizedUrl($file);

		self::$jsFiles[$file] = array(
			'targetie' => $targetie
		);
	}

	/**
	 * css 파일 unload
	 * @param string $file 파일 경로
	 * @return void
	 */
	public static function unloadCss($file)
	{
		$file = self::_getNormalizedUrl($file);

		unset(self::$cssFiles[$file]);
	}

	/**
	 * js 파일 unload
	 * @param string $file 파일 경로
	 * @return void
	 */
	public static function unloadJs($file)
	{
		$file = self::_getNormalizedUrl($file);

		unset(self::$jsFiles[$file]);
	}

	/**
	 * meta 정보 추가
	 * @todo 완성할 것
	 * @return void
	 */
	public static function addMeta($meta)
	{
		foreach($meta as $key => $value)
		{
			self::$meta[$key] = $value;
		}
	}

	/**
	 * 등록된 모든 css 파일 반환
	 * @return array
	 */
	public static function getCssFiles()
	{
		return self::$cssFiles;
	}

	/**
	 * 등록된 모든 js 파일 반환
	 * @return array
	 */
	public static function getJsFiles()
	{
		return self::$jsFiles;
	}

	/**
	 * 현재 페이지의 브라우저 제목을 반환한다
	 * @return string
	 */
	public static function getTitle()
	{
		return self::$title;
	}

	/**
	 * 현재 페이지의 브라우저 제목을 지정한다
	 * @param string $title 지정할 브라우저 제목
	 * @return void
	 */
	public static function setTitle($title = '')
	{
		self::$title = $title;
	}

	/**
	 * 현재 페이지의 브라우저 제목 바로 뒤에 제목을 덧붙인다
	 * @param string $title 추가할 브라우저 제목
	 * @return void
	 */
	public static function addTitle($title)
	{
		self::$title .= $title;
	}
	
	private static function _getNormalizedUrl($url)
	{
		$url = trim($url);

		if(substr($url, 0, 1) == '/')
		{
			$url = substr($url, 1);
		}

		return BASEURL . $url;
	}
}