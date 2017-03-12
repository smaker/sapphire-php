<?php

namespace Module\Member;

use Core\Database as DB;
use Core\Input;
use Core\Output;
use Core\Encrypt;
use Core\Response;

class AdminController extends \Core\Module\Controller
{
	public function __construct()
	{
		$this->db = DB::getConnection();
	}
	
	public function addMember()
	{
		$userId = Input::post('userId');
		$userName = Input::post('userName');
		$nickName = Input::post('nickName');
		$password = Input::post('password');
		$emailAddress = Input::post('emailAddress');
		
		$data = array(
			'userId' => $userId,
			'userName' => $userName,
			'nickName' => $nickName,
			'password' => Encrypt::sha512($password),
			'emailAddress' => $emailAddress
		);

		$this->db->insert('st_member', $data);
		
		if($this->db->getError())
		{
			Output::error($this->db->getError());
		}
		else
		{
			$redirectUrl = BASEURL . 'admin/member';
			header('Location: ' . $redirectUrl);
			exit();
		}
	}

	/**
	 * 그룹 추가
	 */
	public function addMemberGroup()
	{
		$groupName = Input::post('groupName');
		$groupMark = Input::file('groupMark');
		$groupDescription = Input::post('groupDescription');
		if(!$groupName)
		{
			htmlHeader();
			alertScript('그룹명을 입력해주세요.', TRUE);
			htmlFooter();
			exit();
		}

		$data = array(
			'groupName' => $groupName
		);

		$this->db->insert('st_member_group', $data);

		if($this->db->getError())
		{
			Output::error($this->db->getError());
		}
		else
		{
			$redirectUrl = BASEURL . 'admin/member/group';
			header('Location: ' . $redirectUrl);
			exit();
		}
	}

	/**
	 * 그룹 편집
	 */
	public function editMemberGroup()
	{

	}

	/**
	 * 그룹 삭제
	 */
	public function deleteMemberGroup()
	{
		$groupId = Input::post('groupId');
		if(!$groupId)
		{
			htmlHeader();
			alertScript('groupId가 넘어오지 않았습니다.', TRUE);
			htmlFooter();
			exit();
		}

		$this->db->where('groupId', $groupId)->delete('st_member_group');
		if($this->db->getError())
		{
			Output::error($this->db->getError());
		}
		else
		{
			$redirectUrl = BASEURL . 'admin/memer/group';
			header('Location: ' . $redirectUrl);
			exit();
		}
	}
	
	/**
	 * 회원 삭제
	 */
	public function deleteMember()
	{
		$memberId = Input::post('memberId');
		
		$this->db->whereIn('memberId', $memberId)->delete('st_member');

		$json = array();
		$json['success'] = true;

		if($this->db->getError())
		{
			$json['success'] = false;
			$json['message'] = $this->db->getError();
		}

		Response::toJSON($json);
	}
}