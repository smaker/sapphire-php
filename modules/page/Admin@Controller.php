<?php

namespace Module\Page;

use Core\Uri;
use Core\Input;

class AdminController extends \Core\Module\Controller
{
	public function pageEdit()
	{
		// 페이지 고유 번호
		$uniqueID = Uri::get(3);

		// 기본 설정
		$id = Input::post('id');
		// 페이지 제목
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

		$query = sprintf($query, addslashes($id), addslashes($title), addslashes($uniqueID));
		$this->db->query($query);

		// 부가 설정... instance_config 테이블에 넣을 것들
		$siteTheme = Input::post('siteTheme');
		$content = Input::post('content');

		$config = array(
			'siteTheme' => $siteTheme,
			'content' => $content
		);

		\Core\Module\Instance\Handler::putConfig($uniqueID, 'default', $config);

		header('Location: /admin/page/edit/' . $uniqueID);
	}
}