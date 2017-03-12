<?php
namespace Core\Module;


class View extends Base
{
	private $var;
	private $templatePath;
	private $templateFile;
	private $layoutPath;

	public function __construct()
	{
		parent::__construct();
		
		$this->templatePath = MODULEDIR . $this->module . '/view/';
	}

	public function __destruct()
	{
		parent::__destruct();
	}

	public function setLayoutPath($layoutPath)
	{
		$this->layoutPath = BASEDIR . $layoutPath;
	}

	public function getLayoutPath()
	{
		return $this->layoutPath;
	}

	public function setTemplateVar($var)
	{
		$this->var = $var;
	}

	public function getTemplateVar()
	{
		return $this->var;
	}
	
	public function setTemplatePath($path)
	{
		$this->templatePath = $path;
	}

	public function setTemplateFile($file)
	{
		$this->templateFile = $file . '.php';
	}

	public function getTemplateFile()
	{
		return $this->templatePath . '/' . $this->templateFile;
	}
}