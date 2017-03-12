<?php
namespace Module\Page;

use Core\Theme;

class AdminView extends \Core\Module\View
{
	public function pageList()
	{
		$result = $this->db->select('*')->from('st_instances')->where('type', 'page')->get();

		$row = array();

		while($obj = $result->fetch_object())
		{
			$row[] = $obj;
		}

		$result->close();
		$this->setLayoutPath('modules/admin/view/_layout.php');
		$this->setTemplateVar(['instances' => $row]);
		$this->setTemplatePath('./modules/page/view/');
		$this->setTemplateFile('pageList');
	}
	
	public function pageEdit()
	{
		$id = \Core\Uri::get(3);

		$page = $this->db->select('*')->from('st_instances')->where('instanceId', $id)->get()->fetch_object();
		$page->config = \Core\Module\Instance\Handler::getConfig($id);

		$var = array(
			'siteThemes' => Theme::getInstalledThemes(),
			'page' => $page
		);

		$this->setLayoutPath('modules/admin/view/_layout.php');
		$this->setTemplateVar($var);
		$this->setTemplatePath('./modules/page/view/');
		$this->setTemplateFile('pageEdit');
	}
}