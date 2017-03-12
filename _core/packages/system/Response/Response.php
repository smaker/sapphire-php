<?php
namespace Core;

class Response
{
	public static function toHTML($content)
	{
		if(!headers_sent())
		{
			header('Content-Type: text/html; charset=utf-8');
		}

		$template = new Template('./common/view/commonLayout.php');
		$template->assign('title', Frontend::getTitle());
		$template->assign('content', $content);
		echo $template;
	}

	public function toXML()
	{
		if(!headers_sent())
		{
			header('Content-Type: text/xml; charset=utf-8');
		}
	}

	public static function toJSON($data)
	{
		if(!headers_sent())
		{
			header('Content-Type: application/json; charset=utf-8');
		}

		echo json_encode($data);
	}

	public static function error($errstr)
	{
		$template = new Template('./common/errors/500.php');
		$template->assign('errstr', $errstr);
		self::toHTML($template);
	}

	public function notAuthorized()
	{
		$template = new Template('./common/errors/401.php');
		self::toHTML($template);
	}

	public static function forbidden()
	{
		$template = new Template('./common/errors/403.php');
		self::toHTML($template);
	}

	public static function notFound()
	{
		$template = new Template('./common/errors/404.php');
		self::toHTML($template);
	}

	/**
	 * 지정한 페이지로 redirection 하도록 설정
	 *
	 * @param string $url 이동할 URL
	 * @param integer $http_response_code HTTP 상태 코드
	 *
	 * @return void
	 */
	public static function redirect($url, $http_response_code = 301)
	{
		header('Location: '. $url, TRUE, $http_response_code);
		exit();
	}
}

class_alias('Core\Response', 'Core\Output');