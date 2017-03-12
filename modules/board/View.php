<?php
namespace Module\Board;

use Core\Database;
use Core\Template;
use Core\Response;
use Core\Uri;
use Core\Frontend;
use Core\Router;

/**
 * board 모듈의 view class
 * @class View
 * @author SMaker <master@sensitivecms.com>
 */
class View extends \Core\Module\View
{
	/**
	 * View 실행 시 항상 초기화할 작업
	 */
	public function __construct()
	{
		parent::__construct('');
		if(!$this->instance)
		{
			$id = Uri::get(0);

			$this->instance = instance($id, 0);
			$this->module = 'board';
		}

		// 게시판 제목
		//Frontend::setTitle($this->instance->title);

		$this->config = \Core\Module\Instance\Handler::getConfig($this->instance->instanceId);
		$this->permission = \Core\Module\Instance\Handler::getConfig($this->instance->instanceId, 'permission');

		if(!$this->config->listCount)
		{
			$this->config->listCount = 20;
		}

		if(!$this->config->pageCount)
		{
			$this->config->pageCount = 10;
		}

		$this->instance->config = $this->config;
	}

	/**
	 * 게시판 목록
	 */
	public function boardList()
	{

		$id = Uri::get(0);

		$second = Uri::get(1);

		// page

		$page = 1;

		switch($second)
		{
			case 'page':
				$page = (int) Uri::get(2);
				break;
			case 'edit':
				$this->boardEdit();
				return;
				break;
			case 'create':
				$this->boardWrite();
				return;
				break;
			default:
				if($second && is_integer(intval($second)))
				{
					$this->boardRead();
					return;
				}
				else
				{
					$page = 1;
				}
		}

		if(!$page)
		{
			$page = 1;
		}

		self::__construct();

		$instance = $this->instance;

		$listCount = $this->config->listCount;
		$pageCount = $this->config->pageCount;

		// 전체 글 수
		$totalCount = $this->db->select(array('count(*)' => 'totalCount'))->from('st_article')->where('instanceId', $instance->instanceId)->get()->fetch_object()->totalCount;
		$totalPage = max(ceil($totalCount / $listCount), 1);


		$startOffset = ($page - 1) * $listCount;

		$result = $this->db->select('*')->from('st_article')->where('instanceId', $instance->instanceId)->limit($startOffset, $listCount)->orderBy('articleId DESC')->get();


		$i = $totalCount - ($page - 1) * $listCount;

		$list = array();

		while($row = $result->fetch_object())
		{
			$list[$i] = new ArticleEntity($row);
			$i--;
		}

		$result = $this->db->select('*')->from('st_article')->where(array('instanceId' => $instance->instanceId, 'isNotice' => 'Y'))->orderBy('articleId DESC')->get();

		$noticeList = array();
		while($row = $result->fetch_object())
		{
			$noticeList[] = new ArticleEntity($row);
		}

		$var = array(
			'instance' => $instance,
			'list'=> $list,
			'noticeList' => $noticeList,
			'page' => $page,
			'totalCount' => $totalCount,
			'totalPage' => $totalPage
		);

		$this->setTemplateVar($var);
		$this->setTemplatePath($this->getThemePath($this->config->boardTheme));
		$this->setTemplateFile('list');

		return $this;
	}

	/**
	 * 게시판 글쓰기
	 */
	public function boardWrite()
	{
		if(!isset($this->instance->instanceId))
		{
			header('HTTP/1.0 404 Not Found');
			Response::notFound();
			exit();
		}

		Frontend::setTitle($this->instance->title);

		$this->setTemplatePath($this->getThemePath($this->config->boardTheme));
		$this->setTemplateFile('create');

		return $this;
	}

	/**
	 * 게시물 수정
	 */
	public function boardEdit()
	{
		$articleId = Uri::get(2);

		$article = $this->db->select(array('articleId', 'memberId', 'title', 'content'))->from('st_article')->where('articleId', $articleId)->getOne();

		// 글이 없다면
		if(!isset($article->articleId))
		{
			Response::notFound();
			exit();
		}

		$loggedInfo = \Module\Member\Model::getLoggedMember();

		if(!$loggedInfo->isAdmin() && isset($_SESSION['memberId']) && $article->memberId != $_SESSION['memberId'])
		{
			$this->_boardMessage('수정 권한이 없습니다.');
			return;
		}

		$title = Frontend::addTitle(' - ' . $article->title);

		$var = array(
			'article' => $article,
			'instance' => $this->instance
		);

		$this->setTemplateVar($var);
		$this->setTemplatePath($this->getThemePath($this->config->boardTheme));
		$this->setTemplateFile('edit');

		return $this;
	}

	/**
	 * 게시물 열람
	 * @todo 게시물이 없을 경우 not found 에러 출력 필요
	 */
	public function boardRead()
	{
		$articleId = Uri::get(1);

		$article = $this->db->select(array('articleId', 'title', 'content', 'nickName', 'commentCount', 'createAt', 'viewCount'))->from('st_article')->where('articleId', $articleId)->getOne();
		// 글이 없다면
		if(!isset($article->articleId))
		{
			Response::notFound();
			exit();
		}

		$title = Frontend::addTitle(' - ' . $article->title);

		$article = new ArticleEntity($article);

		$var = array(
			'article' => $article,
			'instance' => $this->instance
		);

		$this->setTemplateVar($var);
		$this->setTemplatePath($this->getThemePath($this->config->boardTheme));
		$this->setTemplateFile('read');

		return $this;
	}

	/**
	 * 게시물 삭제
	 */
	public function boardDelete()
	{
		$articleId = Uri::get(2);

		$article = $this->db ->select(array('articleId', 'title', 'content', 'commentCount'))->from('st_article')->where('articleId', $articleId)->getOne();
		// 글이 없다면
		if(!isset($article->articleId))
		{
			Response::notFound();
			exit();
		}

		$template = new Template();
		$template->assign('article', $article);
		$template->assign('instance', $this->instance);
		$layout = $template->view(ST_BASEDIR . 'modules/board/skins/semantic-ui/delete.php', TRUE);
		Response::toHTML($layout);
	}

	public function boardDeleteComment()
	{
		$commentId = Uri::get(3);

		$comment = $this->db->select('*')->from('st_comment')->where('commentId', $commentId)->getOne();

		$var = array(
			'comment' => $comment,
			'instance' => $this->instance
		);

		$this->setTemplateVar($var);
		$this->setTemplatePath($this->getThemePath($this->config->boardTheme));
		$this->setTemplateFile('deleteComment');

		return $this;
	}

	private function _boardMessage($msg)
	{
		Response::error($msg);
	}
}
