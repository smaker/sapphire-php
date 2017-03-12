<?php
namespace Core\Module;

use Core\Frontend;

/**
 * module theme high class
 * @class Theme
 * @author SimpleCode <simplecode@sensitivecms.com>
 */
class Theme
{
	private $module;
	private $theme;

	/**
	 * Constructor
	 *
	 * @param string $module 소속 모듈
	 * @param string $theme 테마명
	 *
	 */
	public function __construct($module, $theme)
	{
		$this->module = $module;
		$this->theme = $theme;
	}

	/**
	 *
	 * 테마에 포함된 CSS 파일을 불러옵니다.
	 *
	 * @param string $file 불러올 CSS 파일
	 *
	 */
	protected function loadCSS($file)
	{
		$path = $this->getThemeWebPath() . '/assets/css/' . $file;

		Frontend::addCss($path);
	}

	/**
	 *
	 * 테마에 포함된 JS 파일을 불러옵니다.
	 *
	 * @param string $file 불러올 JS 파일
	 *
	 */
	protected function loadJS($file)
	{
		$path = $this->getThemeWebPath() . '/assets/js/' . $file;

		Frontend::addJs($file);
	}
	
	/**
	 * 모듈 테마의 서버 상의 절대 경로를 반환합니다
	 *
	 * @return string
	 *
	 */
	protected function getThemePath()
	{
		return MODULEDIR . '/' . $this->module . '/' . $this->theme;
	}
	
	/**
	 * 모듈 테마의 웹 상의 절대 경로를 반환합니다
	 *
	 * @return string
	 *
	 */
	protected function getThemeWebPath()
	{
		return BASEURL . '/modules/' . $this->module . '/' . $this->theme;
	}
}