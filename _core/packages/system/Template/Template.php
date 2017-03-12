<?php
namespace Core;

class Template
{
	// 템플릿 파일에 정의된 지역변수
	private $variables = array();
	// 템플랏 파일 경로
	private $path = '';

	public function __construct($path, $variables = NULL)
	{
		$this->path = $path;
		if($variables !== NULL && count($variables) > 0)
		{
			$this->variables = $variables;
		}
	}

	public function __toString()
	{
		return $this->_compile($this->path);
	}

	/**
	 * 지역변수 정의
	 *
	 * @return void
	 */
	public function assign($key, $value)
	{
		$this->variables[$key] = $value;
	}

	/**
	 * 컴파일 후 cache 파일에 저장
	 *
	 * @return string
	 */
	private function _compile($path)
	{
		$compiled = TemplateHandler::compile($path, FALSE, $this->variables);

		return $compiled;
	}
	
	private function _replaceResource($matches)
	{
		return TemplateHandler::_replaceResource($matches);
	}
}