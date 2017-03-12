<?php
/**
 * 회원 모듈
 * @package Module\Member
 */
namespace Module\Member;

use Core\Frontend;
use Core\Template;
use Core\Response;
use Core\Input;

/**
 * member module의 view class
 * @class View
 */
class View extends \Core\Module\View
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$module = new \stdClass();
		$module->type = 'member';

		$this->setModule($module);
	}
	/**
	 * 로그인 페이지
	 */
	public function login()
	{
		// 로그인 후 이동할 페이지 URL
		$returnUrl = Input::get('from');

		if(!$returnUrl)
		{
			$returnUrl = isset($_SESSION['returnUrl']) ? $_SESSION['returnUrl'] : '';
		}
		if(!$returnUrl)
		{
			$returnUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		}
		if(!$returnUrl)
		{
			$returnUrl = BASEURL;
		}

		// 이미 로그인 한 상태라면
		if(\Module\Member\Model::isLogged())
		{
			// 이전 페이지로 이동한다
			Response::redirect($returnUrl);
		}

		$_SESSION['returnUrl'] = $returnUrl;

		// 페이지 제목 지정
		Frontend::setTitle('로그인');

		$var = array(
			'from' => $returnUrl
		);

		$this->setLayoutPath('common/view/commonLayout.php');
		$this->setTemplateVar($var);
		$this->setTemplatePath('./modules/member/view/');
		$this->setTemplateFile('login');
	}

	/**
	 * 회원 가입 페이지
	 */
	public function join()
	{
		Frontend::setTitle('회원 가입');

		Frontend::addJs('/modules/member/view/js/join.js');

		$this->setLayoutPath('common/view/commonLayout.php');
		$this->setTemplatePath('./modules/member/view/');
		$this->setTemplateFile('join');
	}

	/**
	 * 로그아웃
	 */
	public static function logout()
	{
		Controller::logout();
	}

	/**
	 * 회원 페이지
	 */
	public function memberPage()
	{

	}
}
