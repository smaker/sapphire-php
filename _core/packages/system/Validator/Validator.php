<?php
namespace Core;

class Validator
{
	private static $rules = array(
		'alpha' => '/^[a-z]+$/i',
		'alphanum' => '/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/',
		'number' => '/^(0|[1-9]\d*)$/',
		'integer' => '/^-?(0|[1-9]\d*)$/',
		'float' => '/^(\d+(\.\d+)?)/',
		'email' => '/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i',
		'url' => '/(((ftp|http|https):\/\/)|(\/)|(..\/))(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/',
		'koreatel' => '/^0[1-9]+-[0-9]{3,4}-[0-9]{3,4}$/',
		'koreaphone' => '^(010|011|016|017|018|019|0310|0502|0505|0506)-[0-9]{3,4}-[0-9]{4}$',
		'ipaddress' => '/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/'
	);

	private static $errorMessages = array();
	
	private static $userDefinedRules = array();

	public static function validate($str, $rule)
	{
		$str = trim($str);

		if(is_array($rule))
		{
			if(isset($rule['required']) && $rule['required'] === TRUE && empty($str))
			{
				array_push('', self::$errorMessages);
				return FALSE;
			}
			
			if(isset($rule['length'] && !empty($rule['length']))
			{
				if(strpos($rule['length'], ':') === FALSE)
				{
					if(mb_strlen($str, 'UTF-8') > $rule['length'])
					{
						return FALSE;	
					}
				}
				else
				{
					list($minLength, $maxLength) = explode(':', $rule['length']);
					
					$length = mb_strlen($str, 'UTF-8');
					if($length < $minLength)
					{
						return FALSE;
					}
					
					if($length > $maxLength)
					{
						return FALSE;
					}
				}
			}

			if(preg_match($rule['name'], $str))
			{
				return TRUE;
			}

			return FALSE;
		}

		if(preg_match($rule, $str))
		{
			return TRUE;
		}
   		return FALSE;
	}
			   
	public static function getErrorMessages()
	{
				   
	}
}