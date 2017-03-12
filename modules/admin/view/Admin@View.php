<?php
namespace Module\Admin;

use Core\Frontend;
use Core\Template;
use Core\Site;

/**
 * admin 모듈의 view class
 * @class View
 * @author SimpleCode <simplecode@sensitivecms.com>
 */
class AdminView extends \Core\Module\View
{
	/**
	 * 초기화
	 */
	public function __construct()
	{
		$member = \Module\Member\Model::getLoggedMember();
		if(!$member->isAdmin())
		{
			throw new \Module\Member\Exception\IsNotAdministrator('관리자로 로그인 해 주세요. <br><a href="/auth/login" class="ui button">로그인</a>');
		}

		$module = new \stdClass();
		$module->type = 'admin';

		$this->setModule($module);

		Frontend::addJs('/common/js/js.cookie-2.1.0.min.js');
	}
	/**
	 * 대시보드
	 */
	public function dashboard()
	{
		Frontend::addJs('./modules/admin/view/js/dashboard.js');

		$isSiteExists = Site::isSiteExists();

		$cacheUsage = prettyFileSize($this->_folderSize(BASEDIR . '_core/cache/template'));

		$var = array(
			'isSiteExists' => $isSiteExists,
			'WebServer' => $_SERVER['SERVER_SOFTWARE'],
			'CacheUsage' => $cacheUsage
		);

		$this->setLayoutPath('modules/admin/view/_layout.php');
		$this->setTemplateVar($var);
		$this->setTemplatePath('./modules/admin/view');
		$this->setTemplateFile('dashboard');
	}

	/**
	 * 사이트 생성
	 */
	public function siteCreate()
	{
		$this->setLayoutPath('modules/admin/view/_layout.php');

		$this->setTemplatePath('./modules/admin/view');
		$this->setTemplateFile('siteCreate');
	}

	public function siteThemes()
	{
		$this->setLayoutPath('modules/admin/view/_layout.php');

		$this->setTemplatePath('./modules/admin/view');
		$this->setTemplateFile('siteThemes');
	}

	private function _folderSize($dir)
	{
		$size = 0;
		$dh = scandir($dir);

		foreach($dh as $key => $filename)
		{
			if($filename != '..' && $filename != '.' && $filename != '.gitignore')
			{
				if(is_file($dir . '/' . $filename))
				{
					$size += filesize($dir . '/'.$filename);
				}
			   }
		 }
		return $size;
	}
}
