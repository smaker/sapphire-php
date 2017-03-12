<?php
namespace Core;

class Encrypt
{ 
	public static function sha256($str)
	{
		return hash('sha256', $str);
	}

	public static function sha512($str)
	{
		return hash('sha512', $str);
	}
}