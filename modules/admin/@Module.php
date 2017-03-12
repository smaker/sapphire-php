<?php
namespace Module\Admin;

use Core\Router;

class Base extends \Core\Module\Base
{
	public $defaultViewMethod = '';

	private $adminMenu = array();

	public function __construct()
	{
		Router::fixed('admin', 'admin.AdminView.dashboard');
		Router::fixed('admin/flushCache.do', 'admin.AdminController.flushCache');

		Router::fixed('admin/design', 'admin.AdminView.siteThemes');

		// 사이트 생성
		Router::fixed('admin/site/create', 'admin.AdminView.siteCreate');

		Router::post('admin/setDefaultTheme.do', 'admin.AdminController.setDefaultTheme');
	}

	public function addMenu($menu, $title, $link = '#', $icon = NULL, $items = array())
	{
		$menuItem = new \stdClass;
		$menuItem->title = $title;
		$menuItem->link = $link;
		$menuItem->icon = $icon;
		$menuItem->items = $items;
		$menuItem->itemCount = count($items);

		$this->adminMenu[$menu] = $menuItem;
	}

	public function getAdminMenu()
	{
		return $this->adminMenu;
	}
}
