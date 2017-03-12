<?php
namespace Core;

class TemplateHandler
{
	const CACHE_DIR = COREDIR . 'cache/template/';

	private static $variables = array();
	
	public function __construct() {
		if(!is_dir(self::CACHE_DIR))
		{
			$omask = umask(0000);
			mkdir(self::CACHE_DIR, 0707);
			umask($omask);
		}
	}

	public static function compile($path, $getCacheFilePath = FALSE, $variables = array())
	{
		$cachePath = self::CACHE_DIR . md5($path) . '.php';
		
		$isCacheExpired = !file_exists($cachePath) || (time() - filemtime($cachePath)) > 0 || (time() - filemtime(__FILE__)) > 0;
		
		if(count($variables) > 0)
		{
			self::$variables = $variables;
		}

		// 캐시파일이 만료되었다면
		if($isCacheExpired)
		{
			$compiled = file_get_contents($path);

			// 주석 제거
			$compiled = preg_replace('/{{ --.*? }}/s', '', $compiled);
			// include 문법 컴파일
			$compiled = preg_replace('#<include file="(.*)">#', '<?php echo \Core\TemplateHandler::compile(\'' . dirname($path) . '/$1\'); ?>', $compiled);
			// {{ $variable }} 문법 컴파일
			$compiled = preg_replace_callback('#\{\{ (\$[\w->]+|[A-Z_]+[A-Z_\-0-9]|\$?[a-zA-Z_\\\]+[a-zA-Z0-9_\->\:]+\([^\r\n]*\)) \}\}#', 'self::_replaceResource', $compiled);
			// if 문법 컴파일
			$compiled = preg_replace('#\{\{ @(if|elseif) \(([\S ]+)\) \}\}#', '<?php $1($2) { ?>', $compiled);
			$compiled = str_replace('{{ @else }}', '<?php } else { ?>', $compiled);
			// for/foreach/while 문법 컴파일
			$compiled = preg_replace('#\{\{ @(for|foreach|while) \(([\S ]+)\) \}\}#', '<?php $1($2) { ?>', $compiled);
			// end/endif/endfor/endwhile/endforeach 문법 컴파일
			$compiled = str_replace(array('{{ @end }}', '{{ @endif }}', '{{ @endfor }}', '{{ @endwhile }}', '{{ @endforeach }}'), '<?php } ?>', $compiled);

			file_put_contents($cachePath, $compiled);
		}

		if($getCacheFilePath)
		{
			return $cachePath;
		}

		ob_start();

		foreach(self::$variables as $key => $value)
		{
			$$key = $value;
		}

		require $cachePath;

		$compiled = ob_get_contents();

		ob_end_clean();

		return $compiled;
	}
	
	public static function _replaceResource($matches)
	{
		if(substr_compare($matches[1], '$', 0, 1) === 0)
		{
			return '<?php if(isset(' . $matches[1] . ')) echo ' . $matches[1] . '; ?>';
		}

		// instance의 method를 호출하는 경우
		if(preg_match('#^\$[\w]+\->[\w]+\([^\r\n]*\)$#', $matches[1]) !== FALSE)
		{
			return '<?php echo ' . $matches[1] . '; ?>';
		}
		
		// class의 static method를 호출하는 경우
		if(preg_match('#^[\w]+::[\w]+\([^\r\n]*\)$#', $matches[1]) !== FALSE)
		{
			return '<?php echo ' . $matches[1] . '; ?>';
		}

		return '<?php if(defined(\'' . $matches[1] . '\')) echo ' . $matches[1] . '; ?>';
	}
}