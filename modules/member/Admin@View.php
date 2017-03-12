<?php
namespace Module\Member;

use Core\Frontend;
use Core\Response;
use Core\Uri;

class AdminView extends \Core\Module\View
{
	const STATUS_STANDBY = "대기";
	const STATUS_APPROVED = "승인";
	const STATUS_DENIED = "차단";

	public function __construct()
	{
		$module = new \stdClass();
		$module->type = 'member';

		$this->setModule($module);

		parent::__construct();
	}

	/**
	 * 회원 목록
	 */
	public function memberList()
	{
		// 추출할 값
		$columnList = array(
			'memberId',
			'userId',
			'userName',
			'nickName',
			'status',
			'isAdmin',
			'createdAt',
			'loginAt'
		);

		Frontend::setTitle('회원 목록');
		Frontend::addJs('/modules/member/view/js/memberList.js');

		$result = $this->db->select($columnList)->from('st_member')->get();

		$list = array();
		while($row = $result->fetch_object())
		{
			$list[] = $row;
		}

		$var = array(
			'list' => $list
		);

		$this->setLayoutPath('modules/admin/view/_layout.php');
		$this->setTemplateVar($var);
		$this->setTemplateFile('list');
	}

	/**
	 * 회원 그룹 목록
	 *
	 */
	public function memberGroupList()
	{
		Frontend::addTitle('회원 그룹');
		
		$result = $this->db->select('*')->from('st_member_group')->get();
		
		$list = array();
		
		while($row = $result->fetch_object())
		{
			$list[] = $row;
		}

		$var = array(
			'groupList' => $list
		);

		$this->setLayoutPath('modules/admin/view/_layout.php');
		$this->setTemplateVar($var);
		$this->setTemplateFile('memberGroupList');
	}

	public function memberCreate()
	{
		Frontend::addTitle('회원 추가');
		
		$result = $this->db->select('*')->from('st_member')->get();
		
		$list = array();
		
		while($row = $result->fetch_object())
		{
			$list[] = $row;
		}

		$var = array(
			'memberList' => $list
		);

		$this->setLayoutPath('modules/admin/view/_layout.php');
		$this->setTemplateVar($var);
		$this->setTemplateFile('memberCreate');
	}
	
	/**
	 * 회원 정보 보기 / 수정
	 */
	public function memberEdit()
	{
		$memberId = Uri::get(3);

		Frontend::addTitle('회원 정보 수정');
		
		$member = $this->db->select('*')->from('st_member')->where('memberId', $memberId)->getOne();
		
		$var = array(
			'member' => $member
		);

		$this->setLayoutPath('modules/admin/view/_layout.php');
		$this->setTemplateVar($var);
		$this->setTemplateFile('memberEdit');
	}
}