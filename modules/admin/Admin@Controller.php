<?php

namespace Module\Admin;

use Core\Response;

class AdminController extends \Core\Module\Controller
{
	public function flushCache()
	{
		$cacheDir = COREDIR . 'cache/template';

		$dh = scandir($cacheDir);

		foreach($dh as $key => $filename)
		{
			if($filename != '..' && $filename != '.' && $filename != '.gitignore' && $filename != 'index.html')
			{
				if(is_file($cacheDir . '/' . $filename))
				{
					unlink($cacheDir . '/' . $filename);
				}
			}
		 }

		$response = new \stdClass;
		$response->message = '모든 캐시파일이 삭제되었습니다.';

		Response::toJSON($response);
	}

	/**
	 * 기본 테마 설정
	 */
	public function setDefaultTheme()
	{
		$response = new \stdClass;
		$response->success = true;

		Response::toJSON($response);
	}
}
