<?php

namespace Core;

use Core\Database as DB;

class Site
{
	public static function getSites()
	{
		$db = DB::getConnection();
		return $db->select('*')->from('st_sites')->get();
	}

	public static function getDefaultSite()
	{
		$db = DB::getConnection();
		return $db->select('*')->from('st_sites')->where('isDefault', 'Y')->getOne();
	}
	
	public static function findSite($hostname, $path)
	{
		$db = DB::getConnection();
		
		if($path)
		{
			$siteInfo = $db->select('*')->from('st_sites')->where('siteUrl', $hostname . '/' . $path)->getOne();
		}
		else
		{
			$siteInfo = $db->select('*')->from('st_sites')->where('siteUrl', $hostname)->getOne();
		}
		
		return $siteInfo;
	}

	public static function isSiteExists()
	{
		$db = DB::getConnection();
		return $db->select('count(*)')->from('st_sites')->getOne()->{'count(*)'} > 0;
	}
}