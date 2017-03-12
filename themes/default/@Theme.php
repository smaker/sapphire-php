<?php
namespace Theme;

use Core\Response;
use Core\Template;
use Core\Frontend as FrontEnd;

class DefaultTheme
{
	public function __construct()
	{
		
	}
	
	public function render($contents = NULL)
	{
		FrontEnd::addCss('/themes/default/assets/css/theme.css');

		$template = new Template(__DIR__ . '/theme.html');
		$template->assign('contents', $contents);

		return $template;
	}
}