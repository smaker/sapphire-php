<?php

namespace Module\Page;

use Core\Uri;

class View extends \Core\Module\View
{
	public function __construct()
	{
		parent::__construct('');
		if(!$this->instance)
		{
			$id = Uri::get(0);

			$this->instance = instance($id, \bootloader::getCurrentSiteInfo()->siteId);
			$this->module = 'page';
		}

		$this->config = \Core\Module\Instance\Handler::getConfig($this->instance->instanceId);
	}
	public function pageView()
	{
		$var = array(
			'pageContent' => $this->config->content
		);

		$this->setTemplateVar($var);
		$this->setTemplateFile('pageView');

		return $this;
	}
}
