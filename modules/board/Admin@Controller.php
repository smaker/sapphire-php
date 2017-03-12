<?php
namespace Module\Board;

use Core\Input;
use Core\Uri;

class AdminController extends \Core\Module\Controller
{

	/**
	 * 게시판 설정 저장
	 */
	public function saveBoard()
	{
		// 게시판 고유 번호
		$boardNo = Uri::get(3);

		// 기본 설정
		$id = Input::post('id');
		$title = Input::post('title');

		$query = '
		UPDATE
			`st_instances`
		SET
			`id` = "%s",
			`title` = "%s"
		WHERE
			`instanceId` = %d
		';

		$query = sprintf($query, addslashes($id), addslashes($title), addslashes($boardNo));
		$this->db->query($query);

		// 부가 설정... instance_config 테이블에 넣을 것들
		$listCount = (int) Input::post('listCount');
		$pageCount = (int) Input::post('pageCount');
		$headerText = Input::post('headerText');
		$footerText = Input::post('footerText');
		$siteTheme = Input::post('siteTheme');
		$boardTheme = Input::post('boardTheme');

		$config = array(
			'siteTheme' => $siteTheme,
			'boardTheme' => $boardTheme,
			'listCount' => $listCount,
			'pageCount' => $pageCount,
			'headerText' => $headerText,
			'footerText' => $footerText
		);

		\Core\Module\Instance\Handler::putConfig($boardNo, 'default', $config);

		$_SESSION['TOAST_TYPE'] = 'success';
		$_SESSION['TOAST_MESSAGE'] = '저장되었습니다.';

		header('Location: /admin/board/edit/' . $boardNo);
	}
	
	/**
	 * 게시판 생성
	 */
	public function boardCreate()
	{
		// 게시판 고유 번호
		$boardNo = Uri::get(3);

		// 기본 설정
		$id = Input::post('id');
		$title = Input::post('title');

		$query = 'INSERT INTO `st_instances` (`id`, `title`, `type`) VALUES ("%s", "%s", "board")';

		$query = sprintf($query, addslashes($id), addslashes($title));
		$this->db->query($query);
		
		$boardNo = $this->db->getLastInsertId();

		// 부가 설정... instance_config 테이블에 넣을 것들
		$listCount = (int) Input::post('listCount');
		$pageCount = (int) Input::post('pageCount');
		$headerText = Input::post('headerText');
		$footerText = Input::post('footerText');
		$siteTheme = Input::post('siteTheme');
		$boardTheme = Input::post('boardTheme');

		$config = array(
			'siteTheme' => $siteTheme,
			'boardTheme' => $boardTheme,
			'listCount' => $listCount,
			'pageCount' => $pageCount,
			'headerText' => $headerText,
			'footerText' => $footerText
		);

		\Core\Module\Instance\Handler::putConfig($boardNo, 'default', $config);

		header('Location: /admin/board/edit/' . $boardNo);
	}
}