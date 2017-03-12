<?php
namespace Module\Board\Theme;

class DefaultTheme extends \Core\Module\Theme
{
	public function boardList()
	{
		
	}

	public function render()
	{
		return NULL;
	}

	public function isSupportedPC()
	{
		return TRUE;
	}

	public function isSupportedMobile()
	{
		return TRUE;
	}

	public function isResponsiveTheme()
	{
		return TRUE;
	}
}