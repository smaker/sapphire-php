<?php
namespace Module\Board;

use Core\Router;

class Base extends \Core\Module\Base
{
	public $defaultViewMethod = 'boardList';

	public function __construct()
	{
		Router::get('^[a-z0-9_]+/page/[0-9]+$', 'board.view.boardList');
		Router::get('^[a-z0-9_]+/[0-9]+$', 'board.view.boardRead');
		Router::get('^[a-z0-9_]+/create$', 'board.view.boardWrite');
		Router::get('^[a-z0-9_]+/delete/[0-9]+$', 'board.view.boardDelete');
		Router::get('^[a-z0-9_]+/edit/[0-9]+$', 'board.view.boardEdit');
		Router::get('^[a-z0-9_]+/[0-9]+/comment-delete/[0-9]+$', 'board.view.boardDeleteComment');

		Router::post('^[a-z0-9_]+/delete/[0-9]+$', 'board.controller.deleteArticle');
		Router::post('^[a-z0-9_]+/[0-9]+/comment$', 'board.controller.boardComment');
		Router::post('^[a-z0-9_]+/[0-9]+/comment-delete/[0-9]+$', 'board.controller.boardDeleteComment');

		Router::post('^([a-z]+)/create', 'board.controller.create');
		Router::post('^([a-z]+)/edit$', 'board.controller.edit');

		Router::fixed('admin/board', 'board.AdminView.boardList');
		Router::fixed('admin/board/create', 'board.AdminView.boardCreate');

		Router::get('admin/board/edit/[0-9]+', 'board.AdminView.edit');

		Router::post('admin/board/create', 'board.AdminController.boardCreate');
		Router::post('admin/board/edit/[0-9]+', 'board.AdminController.saveBoard');

		$this->registerMenu();
	}
	
	public function registerRoute()
	{
		
	}
	
	public function registerMenu()
	{
		$items = array();
		$items[0] = new \stdClass;
		$items[0]->title = '게시판 목록';
		$items[0]->link = '/admin/board';
		$items[1] = new \stdClass;
		$items[1]->title = '게시물 관리';
		$items[1]->link = '/admin/board/articles';
		$items[2] = new \stdClass;
		$items[2]->title = '댓글 관리';
		$items[2]->link ='/admin/board/comments';

		$admin = module('admin');
		$admin->addMenu('board', '게시판', '#', 'edit', $items);
	}
}