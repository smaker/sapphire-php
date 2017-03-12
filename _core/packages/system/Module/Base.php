<?php
namespace Core\Module;

/**
 * module base
 * @class Base
 * @author SMaker <master@sensitivecms.com>
 */
class Base
{
	public $instance;

	/**
	 * @var string 모듈명
	 */
	protected $module;

	/**
	 * @var \Core\DatabaseConnection 기본 DB 커넥션
	 */
	protected $db;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		// 기본 DB 커넥션
		$this->db = \Core\Database::getConnection();
	}

	public function __destruct()
	{
		unset($this);
	}

	public function setModule($module)
	{
		$this->module = $module->type;
		$this->instance = $module;
	}

	/**
	 * 모듈 경로를 반환합니다
	 *
	 * @return string
	 */
	public function getModulePath()
	{
		return MODULEDIR . $this->module;
	}

	/**
	 * 모듈의 view 디렉토리 경로를 반환합니다
	 *
	 * @return string
	 */
	public function getViewPath()
	{
		return MODULEDIR . $this->module . '/view';
	}

	/**
	 * 모듈의 theme 디렉토리 경로를 반환합니다
	 *
	 * @deprecated
	 *
	 * @return string
	 */
	public function getSkinPath($skin)
	{
		return $this->getThemePath($skin);
	}
	
	/**
	 * 모듈의 theme 디렉토리 경로를 반환합니다
	 *
	 * @return string
	 */
	public function getThemePath($theme)
	{
		return MODULEDIR . $this->module . '/themes/' . $theme;
	}
}