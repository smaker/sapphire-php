<?php
/**
 * @package Core\Module\Instance
 * @author SMaker <master@sensitivecms.com>
 */
namespace Core\Module\Instance;

use Core\Database as DB;

/**
 * 모듈 각각의 instance를 다루기 위한 handler class
 * @class Handler
 */
class Handler
{
	/**
	 * db에서 해당 instance에 대한 설정을 가져온다
	 *
	 * @param int $instanceId instance id
	 * @param string $section 각각의 설정을 구분하기 위한 이름
	 *
	 * @return mixed
	 */
	public static function getConfig($instanceId, $section = 'default')
	{
		$db = DB::getConnection();

		$config = $db->select('config')->from('st_instance_config')->where(array('instanceId' => $instanceId, 'section' => $section))->getOne();
		if(isset($config->config))
		{
			return json_decode($config->config);
		}

		return new \stdClass;
	}

	/**
	 * db에 해당 instance에 대한 설정이 등록되어 있는지 확인한다
	 *
	 * @param int $instanceId instance id
	 * @param string $section 각각의 설정을 구분하기 위한 이름
	 *
	 * @return boolean
	 */
	public static function isConfigExists($instanceId, $section = 'default')
	{
		$db = DB::getConnection();

		$where = array(
			'instanceId' => $instanceId,
			'section' => $section
		);

		return ($db->select(array('count(*)' => 'count'))->from('st_instance_config')->where($where)->getOne()->count) > 0;
	}

	/**
	 * db에 해당 instance에 대한 설정을 반영한다
	 *
	 * @param int $instanceId instance id
	 * @param string $section 각각의 설정을 구분하기 위한 이름
	 * @param mixed $config 저장할 설정 값
	 * 
	 * @todo 성공 여부에 따라 boolean으로 return하는 것이 좋을듯하다
	 * @return void
	 */
	public static function putConfig($instanceId, $section = 'default', $config)
	{
		$db = DB::getConnection();

		if(self::isConfigExists($instanceId, $section))
		{
			$where = array(
				'instanceId' => $instanceId,
				'section' => $section
			);

			$data = array(
				'config' => json_encode($config)
			);
			$db->where($where)->update('st_instance_config', $data);
		}
		else
		{
			$data = array(
				'instanceId' => $instanceId,
				'section' => $section,
				'config' => json_encode($config)
			);

			$db->insert('st_instance_config', $data);
		}
	}
}