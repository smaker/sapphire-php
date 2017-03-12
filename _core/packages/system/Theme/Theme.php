<?php

namespace Core;

class Theme
{
	/**
	 * 설치된 테마
	 */
	public static function getInstalledThemes()
	{
		$themes = array();

		if($handle = opendir(THEMEDIR))
		{
	    	while (($dir = readdir($handle)) !== FALSE )
		    {
		        if ($dir != '.' && $dir != '..')
		        {
		        	$themes[$dir] = self::getThemeInfo($dir);
            	}
        	}
    	}
    	closedir($handle);

    	return $themes;
	}
	
	/**
	 * 테마 정보를 읽어서 return 한다
	 */
	public static function getThemeInfo($theme)
	{
		$specificThemeDir = THEMEDIR . $theme;
		
		$packageJsonFile = $specificThemeDir . '/package.json';
		
		if(file_exists($packageJsonFile))
		{
			$themeInfo = json_decode(file_get_contents($packageJsonFile));

			// package.json 문법이 잘못된 경우
			if($themeInfo === NULL && json_last_error())
			{
				$themeInfo = new stdClass;
				/**
				 * @todo development 환경인 경우 warning을 출력한다
				 */
			}

			// package.json에서 기본적으로 제공하는 name과 description은 필요하지 않으므로 제거한다.
			unset($themeInfo->name);
			unset($themeInfo->description);
			
			/**
			 * 테마 제목과 설명을 가져온다.
			 *
			 * @todo 다국어 지원 시 수정 필요
			 */
			$themeInfo->title = $themeInfo->themeInfo->title->ko;
			$themeInfo->description = $themeInfo->themeInfo->description->ko;
			
			// 테마 정보에 테마 설치 경로를 추가한다
			$themeInfo->theme_dir = $specificThemeDir;
			
			return $themeInfo;
		}
		
		/**
		 * @todo EmptyPluginInfo를 return 하는 것이 더 좋을듯하다
		 */
		return new stdClass;
	}

	public static function getThemeClass($theme)
	{
		return (strtolower($theme) == 'default') ? 'Theme\\DefaultTheme' : 'Theme\\' . ucfirst($theme);
	}
	
	public static function getTheme($theme)
	{
		//$themeInfo = self::getThemeInfo($theme);
		$themeClass = self::getThemeClass($theme);
		
		$theme = new $themeClass;
		
		return $theme;
	}
}