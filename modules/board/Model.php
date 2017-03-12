<?php
namespace Module\Board;

class Model extends \Core\Module\Model
{
	/**
	 * 게시물 정보를 반환
	 */
	public static function getArticle($articleId, $columnList = '*')
	{
		return \Core\Database::getConnection()->select($columnList)->from('st_article')->where('articleId', $articleId)->getOne();
	}

	/**
	 * 게시물을 entity 형태로 반환
	 */
	public static function getArticleEntity($articleId, $columnList = '*')
	{
		$article = self::$getArticle($articleId, $columnList);
		return new ArticleEntity($article);
	}

	/**
	 * 댓글 정보를 반환
	 */
	public static function getComment($commentId, $columnList = '*')
	{
		return \Core\Database::getConnection()->select($columnList)->from('st_comment')->where('commentId', $commentId)->getOne();
	}
}
