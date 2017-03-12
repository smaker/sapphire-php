<?php
namespace Module\Board;

use Core\Input;
use Core\Uri;
use Core\Response;

/**
 * board 모듈의 controller
 * @class Controller
 */
class Controller extends \Core\Module\Controller
{
	/**
	 * 게시물 등록
	 */
	public function create()
	{
		$id = Uri::get(0);
		$instanceId = instance($id)->instanceId;

		$memberId = (int) $_SESSION['memberId'];
		$title = Input::post('title', TRUE);
		$content = Input::post('content', TRUE);
		$nickName = Input::post('nick_name', TRUE);
		$password = Input::post('password', TRUE);
		$isNotice = Input::post('isNotice');
		$ipaddress = $_SERVER['REMOTE_ADDR'];

		if(!in_array($isNotice, array('Y', 'N')))
		{
			$isNotice = 'N';
		}

		if($memberId)
		{
			$memberInfo = \Module\Member\Model::getMemberInfo($memberId);
			$nickName = $memberInfo->nickName;
			$password = $memberInfo->password;
		}

		// 줄바꿈 처리
		$content = nl2br($content);

		/**
		 * @todo Raw query 대신에 Query Builder를 이용해 쿼리를 짜보자
		 */
		$query = 'INSERT INTO `st_article` (`instanceId`, `memberId`, `title`, `content`, `nickName`, `password`, `isNotice`, `ipaddress`) VALUES (%d, %d, "%s", "%s", "%s", "%s", "%s", "%s")';
		$query = sprintf($query, $instanceId, $memberId, addslashes($title), addslashes($content), addslashes($nickName), addslashes($password), addslashes($isNotice), addslashes($ipaddress));

		$this->db->query($query);

		//if($this->db->error)
		//{
	//	//	echo 'Error : ' . $this->db->error;
	//	}
	//	else
	//	{
			$returnUrl = BASEURL . instance($id)->id;
			Response::redirect($returnUrl, 302);
	//	}
	}

	/**
	 * 게시물 수정
	 */
	public function edit()
	{
		$id = Uri::get(0);
		$instanceId = instance($id)->instanceId;

		if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'])
		{
			$memberId = (int) $_SESSION['memberId'];
		}
		else
		{
			$memberId = 0;	
		}

		$article = \Module\Board\Model::getArticle(Input::post('articleId'));
		if(!isset($article->articleId))
		{
			Response::error('해당 글이 존재하지 않습니다.');
			return;
		}

		$loggedInfo = \Module\Member\Model::getLoggedMember();

		if(!$loggedInfo->isAdmin() && isset($_SESSION['memberId']) && $article->memberId != $_SESSION['memberId'])
		{
			Response::error('수정 권한이 없습니다.');
			return;
		}

		$title = Input::post('title', TRUE);
		$content = Input::post('content');
		$nickName = Input::post('nick_name', TRUE);
		$password = Input::post('password', TRUE);
		$isNotice = Input::post('isNotice');

		if(!in_array($isNotice, array('Y', 'N')))
		{
			$isNotice = 'N';
		}

		if($memberId)
		{
			$memberInfo = \Module\Member\Model::getMemberInfo($memberId);
			$nickName = $memberInfo->nickName;
			$password = $memberInfo->password;
		}

		// 줄바꿈 처리
		$content = nl2br($content);

		/**
		 * @todo Raw query 대신에 Query Builder를 이용해 쿼리를 짜보자
		 */
		$query = 'UPDATE `st_article` SET `title` = "%s", `content` = "%s" WHERE `articleId` = %d';
		$query = sprintf($query, addslashes($title), addslashes($content), Input::post('articleId'));

		$this->db->query($query);

		if(!$this->db->getError())
		{
			$returnUrl = BASEURL . instance($id)->id . '/' . Input::post('articleId');
			Response::redirect($returnUrl, 302);
		}
	}

	/**
	 * 게시물 삭제
	 */
	public function deleteArticle()
	{
		$id = Uri::get(0);
		$articleId = Uri::get(2);

		$this->db->where('articleId', $articleId)->delete('st_article');

		$returnUrl = BASEURL . instance($id)->id;
		Response::redirect($returnUrl, 302);
	}

	/**
	 * 댓글 등록
	 */
	public function boardComment()
	{
		// 인스턴스 아이디
		$instanceId = Uri::get(0);

		// 원본 게시물 번호
		$articleId = Uri::get(1);

		// 부모 댓글 번호
		$parentId = 0;
		// 댓글 깊이
		$depth = 0;

		// 작성자 회원 번호
		if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'])
		{
			$memberId = (int) $_SESSION['memberId'];
		}
		else
		{
			$memberId = 0;	
		}

		if($memberId)
		{
			$memberInfo = \Module\Member\Model::getMemberInfo($memberId);
			$nickName = $memberInfo->nickName;
			$password = $memberInfo->password;
		}

		// 댓글 내용
		$content = Input::post('content');

		// IP 주소
		$ipaddress = $_SERVER['REMOTE_ADDR'];

		/**
		 * @todo Raw query 대신에 Query Builder를 이용해 쿼리를 짜보자
		 */
		$query = 'INSERT INTO `st_comment` (`parentId`, `articleId`, `instanceId`, `memberId`, `content`, `nickName`, `password`, `depth`, `ipaddress`) VALUES (%d, %d, %d, %d, "%s", "%s", "%s", %d, "%s")';
		$query = sprintf($query, $parentId, $articleId, $instanceId, $memberId, addslashes($content), addslashes($nickName), addslashes($password), $depth, addslashes($ipaddress));

		$this->db->query($query);

		// 에러가 발생한 경우 에러를 출력한다
		if($this->db->getError())
		{
			Response::error($this->db->getError());
		}
		// 댓글 작성에 성공한 경우 댓글 수를 갱신하고 이전 페이지로 되돌아간다
		else
		{
			$query = 'UPDATE `st_article` SET `commentCount` = `commentCount` + 1 WHERE `articleId` = ' . addslashes($articleId);
			$this->db->query($query);

			$returnUrl = BASEURL . instance($instanceId)->id . '/' . $articleId;
			Response::redirect($returnUrl, 302);
		}
	}

	public function boardDeleteComment()
	{
		$commentId = Input::post('commentId');
		
		// 해당 댓글의 instance id와 article id를 가져온다
		$comment = $this->db->select(array('commentId', 'instanceId', 'articleId'))->from('st_comment')->where('commentId', $commentId)->getOne();

		// 해당 댓글이 존재하지 않는다면
		if(!isset($comment->commentId))
		{
			Response::error('해당 댓글이 존재하지 않습니다.');
		}

		$where = array(
			'commentId' => $commentId
		);

		$this->db->delete('st_comment', $where);

		if($this->db->getError())
		{
			Response::error($this->db->getError());
		}

		// 댓글 삭제에 성공한 경우 댓글 수를 갱신하고 이전 페이지로 되돌아간다
		else
		{
			$query = 'UPDATE `st_article` SET `commentCount` = `commentCount` - 1 WHERE `articleId` = ' . addslashes($comment->articleId);
			$this->db->query($query);

			$returnUrl = BASEURL . instance($comment->instanceId)->id . '/' . $articleId;
			Response::redirect($returnUrl, 302);
		}
	}
}
