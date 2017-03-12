<?php
/**
 * board 모듈에서 사용되는 각 게시물을 객체로 정의함
 * @package Module\Board
 */
namespace Module\Board;

use Core\Database as DB;

class ArticleEntity
{
	public function __construct($data)
	{
		$this->articleId = $data->articleId;
		$this->title = $data->title;
		$this->content = $data->content;
		$this->nickName = $data->nickName;
		$this->createAt = $data->createAt;
		$this->commentCount = $data->commentCount;
		$this->viewCount = $data->viewCount;
	}

	public function getTitle()
	{
		return escape($this->title);
	}

	public function getContent()
	{
		return $this->content;
	}
	
	public function getCommentCount()
	{
		return $this->commentCount;
	}

	/**
	 * 게시물에 등록된 모든 댓글을 가져옵니다
	 *
	 * @return \Module\Board\CommentEntity
	 */
	public function getComments()
	{
		$db = DB::getConnection();
		$commentList = $db->select('*')->from('st_comment')->where('articleId', $this->articleId)->get();
		
		$comments = array();

		while($comment = $db->fetch($commentList))
		{
			$comments[] =$comment;
		}

		return $comments;
	}
}