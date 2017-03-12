<?php
namespace Module\Member;

use Core\Database;

class Model extends \Core\Module\Model
{
	public static function getMemberInfo($memberId)
	{
		return Database::getConnection()->query('SELECT * FROM `st_member` WHERE `memberId` = "' . addslashes($memberId) . '"')->fetch_object();
	}

	public static function getMemberInfoByUserId()
	{
		return Database::getConnection()->query('SELECT * FROM `st_member` WHERE `userId` = "' . addslashes($userId) . '"')->fetch_object();
	}

	public static function isLogged()
	{
		if(!isset($_SESSION['isLogged']))
		{
			$_SESSION['isLogged'] = FALSE;
			return FALSE;
		}
		
		if(!isset($_SESSION['memberId']))
		{
			$_SESSION['memberId'] = NULL;
			return FALSE;
		}

		if(!$_SESSION['isLogged'] || !$_SESSION['memberId'])
		{
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * 회원 정보를 MemberEntity로 반환합니다
	 */
	public static function getLoggedMember()
	{
		static $memberEntity = NULL;

		if($memberEntity === NULL)
		{
			$memberInfo = self::getLoggedMemberInfo();
			$memberEntity = new MemberEntity($memberInfo);
		}

		return $memberEntity;
	}

	public static function getLoggedMemberInfo()
	{
		if(isset($_SESSION['memberId']))
		{
			return self::getMemberInfo($_SESSION['memberId']);
		}
		return new \stdClass();
	}
}
