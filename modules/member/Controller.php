<?php
namespace Module\Member;

use Core\Input;
use Core\Response;
use Core\Encrypt;

class Controller extends \Core\Module\Controller
{
	public function login()
	{
		$user_id = Input::post('user_id');
		$password = Input::post('password');
		if(!$user_id)
		{
			htmlHeader();
			alertScript('아이디를 입력해주세요.', TRUE);
			htmlFooter();
			exit();
		}

		if(!$password)
		{
			htmlHeader();
			alertScript('비밀번호를 입력해주세요.', TRUE);
			htmlFooter();
			exit();
		}

		$member_info = $this->db->query('SELECT `memberId`, `password` FROM `st_member` WHERE `userId` = "' . addslashes($user_id) . '"')->fetch_object();

		if(isset($member_info->password))
		{
			if($member_info->password == Encrypt::sha512($password))
			{
				$_SESSION['isLogged'] = TRUE;
				$_SESSION['memberId'] = $member_info->memberId;
				$_SESSION['login_token'] = Encrypt::sha512($member_info->memberId . $user_id . $_SERVER['HTTP_USER_AGENT']);
				
				$this->db->where('memberId', $member_info->memberId)->update('st_member', array('loginAt' => date('YmdHis')));
			}
			else
			{
				htmlHeader();
				alertScript('비밀번호가 일치하지 않습니다.');
				htmlFooter();
				exit();
			}
		}
		else
		{
			htmlHeader();
			alertScript('존재하지 않는 아이디입니다.');
			htmlFooter();
			exit();
		}

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
		
		Response::redirect($returnUrl);
	}

	public static function logout()
	{
		$_SESSION['isLogged'] = FALSE;
		unset($_SESSION['memberId']);
		unset($_SESSION['login_token']);
		

		// 로그아웃 후 이동할 페이지 URL
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
		
		Response::redirect($returnUrl);
	}
	
	public function memberJoin()
	{
		$userId = Input::post('userId');
		$password = Input::post('password');
		$password2 = Input::post('password2');
		$userName = Input::post('userName');
		$nickName = Input::post('nickName');
		$emailAddress = Input::post('emailAddress');

		if(!$userId)
		{
			htmlHeader();
			alertScript('아이디를 입력해주세요.', TRUE);
			htmlFooter();
			exit();
		}

		if(!$password)
		{
			htmlHeader();
			alertScript('비밀번호를 입력해주세요.', TRUE);
			htmlFooter();
			exit();
		}

		if(!$password2)
		{
			htmlHeader();
			alertScript('비밀번호를 한 번 더 입력해주세요.', TRUE);
			htmlFooter();
			exit();
		}

		if($password !== $password2)
		{
			htmlHeader();
			alertScript('비밀번호를 똑같이 입력해주세요.', TRUE);
			htmlFooter();
			exit();
		}

		if(!$userName)
		{
			htmlHeader();
			alertScript('이름을 입력해주세요.', TRUE);
			htmlFooter();
			exit();
		}
		
		if(!$nickName)
		{
			htmlHeader();
			alertScript('닉네임을 입력해주세요.', TRUE);
			htmlFooter();
			exit();
		}
		
		if(!$emailAddress)
		{
			htmlHeader();
			alertScript('이메일 주소를 입력해주세요.', TRUE);
			htmlFooter();
			exit();
		}

		$hashedPassword = Encrypt::sha512($password);
		
		$data = [
			'userId' => $userId,
			'userName' => $userName,
			'nickName' => $nickName,
			'password' => $hashedPassword,
			'emailAddress' => $emailAddress,
			'isAdmin' => 'N',
			'status' => 'APPROVED',
			'createdAt' => date('Y-m-d H:i:s')
		];

		$this->db->insert('st_member', $data);

		if($this->db->getError())
		{
			htmlHeader();
			alertScript(addslashes($this->db->getError()));
			htmlFooter();
			exit();
		}

		// 회원가입 후 이동할 페이지 URL
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

		Response::redirect($returnUrl);
	}

	public function doLogin()
	{

	}
}
