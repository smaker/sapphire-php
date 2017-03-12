<?php

namespace Module\Page;

use Core\Router;

Router::fixed('admin/page', 'page.AdminView.pageList');
Router::get('^admin/page/edit/[0-9]+$', 'page.AdminView.pageEdit');
Router::post('^admin/page/edit/[0-9]+$', 'page.AdminController.pageEdit');

class Base extends \Core\Module\Base
{
	public $defaultViewMethod = 'pageView';

	public function __construct()
	{
		Router::fixed('admin/page', 'page.AdminView.pageList');
	}
}