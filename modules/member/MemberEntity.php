<?php
namespace Module\Member;

class MemberEntity
{
	/** @var int 회원 번호 */
	private $memberId;

	/** @var string 사용자 아이디 */
	private $userId;

	/** @var string 사용자 이름 */
	private $userName;

	/** @var string 사용자 닉네임 */
	private $nickName;

	/** @var string 가입일 */
	private $createdAt;

	/** @var string 관리자 여부 */
	private $isAdmin = 'N';

	/**
	 * Constructor
	 */
	public function __construct($data)
	{
		foreach($data as $key => $val)
		{
			$this->$key = $val;
		}
	}

	public function getUserID()
	{
		return escape($this->userId);
	}

	public function getUserName()
	{
		return escape($this->userName);
	}

	public function getNickName()
	{
		return escape($this->nickName);
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function isAdmin()
	{
		return ($this->isAdmin == 'Y');
	}
}