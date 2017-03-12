<?php

spl_autoload_register(function($class){
	$parts = explode('\\', $class);

	$main = $parts[0];
	$second = $parts[1];
	$third = '';

	if(isset($parts[2]))
	{
		$third = $parts[2];
	}

	if(isset($parts[3]))
	{
		$fourth = $parts[3];
	}

	switch($parts[0])
	{
		// 코어
		case 'Core':
			$path = COREDIR;

			switch ($second)
			{
				case 'DatabaseConnection':
					$path .= 'packages/system/Database/DatabaseConnection.php';
					break;
				// 코어 패키지
				default:
					// 패키지 이름
					$packageName = ucfirst($second);
					// 패키지 타입
					$packageType = 'public';
					// 서브 패키지 이름
					$subPackageName = $third;

					// 시스템 패키지인지 확인
					if(in_array($second, SYSTEM_PACKAGES))
					{
						$packageType = 'system';
					}

					if(count($parts) == 2)
					{
						$path .= sprintf('packages/%s/%s/%s.php', $packageType, $packageName, $packageName);
					}
					elseif (count($parts) == 4)
					{
						$path .= sprintf('packages/%s/%s/%s/%s.php', $packageType, $packageName, $subPackageName, $subPackageName);
					}
					else
					{
						$path .= sprintf('packages/%s/%s/%s.php', $packageType, $packageName, ucfirst($subPackageName));
					}
					break;
			}

			switch ($third) {
				case 'FailedDatabaseConnection':
					$path = COREDIR . 'packages/system/Database/Exceptions/FailedDatabaseConnection.php';
					break;

				default:
					# code...
					break;
			}

			if(is_readable($path))
			{
				require $path;
			}
			else
			{
				throw new Exception($second . ' 패키지를 찾을 수 없습니다.' . $class . '\' ' . $path . ' Not Found');
			}
			break;
		// 모듈
		case 'Module':
			$path = MODULEDIR;

			if(in_array($third, array('Model', 'View', 'Controller')))
			{
				$path .= strtolower($second) . '/' . $third . '.php';
			}
			else
			{
				if($third == 'Exception')
				{
					$path .= strtolower($second) . '/Exceptions/' . $fourth . '.php';
				}
				else
					{
					// admin method 처리
					if(substr($third, 0, 5) == 'Admin')
					{
						$path .= strtolower($second) . '/' . 'Admin@' . substr($third, 5) . '.php';
					}
					else
					{
						$path .= strtolower($second) . '/' . $third . '.php';
					}
				}
			}

			if(is_readable($path))
			{
				require $path;
			}
			else
			{
				throw new Exception('설치된 모듈을 찾을 수 없습니다. \' ' . $class . '\' Not Found : ' . $path);
			}
			break;
		// 플러그인
		case 'Plugin':
			break;
		// 테마
		case 'Theme':
			if($second == 'DefaultTheme')
			{
				$second = 'default';
			}

			$path = './themes/';
			$path .= strtolower($second) . '/@Theme.php';

			require $path;

			break;
	}
});
