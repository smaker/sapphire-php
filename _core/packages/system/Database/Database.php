<?php
namespace Core;

/**
 * 여러 개의 DB 접속을 관리하는 class입니다
 * @class Database
 */
class Database
{
	/** @var mixed[] 열려있는 DB 접속 */
	private static $connection = array();

	/** @var string 마지막으로 발생한 오류 */
	private static $error = '';

	public function __construct()
	{
		$db = config('database');

		self::connect($db['hostname'], $db['username'], $db['password'], $db['database'], $db['port']);
	}

	public static function connect($host, $username, $password, $database, $port = 3306)
	{
		self::$connection['default'] = new DatabaseConnection($host, $username, $password, $database, $port);
	}

	/**
	 * 마지막으로 발생한 오류를 반환합니다
	 * @return string
	 */
	public static function getError()
	{
		return self::$error;
	}

	/**
	 * 열린 DB 접속을 가져옵니다
	 * @return DatabaseConnection
	 * @todo 존재하지 않는 connection 인 경우 InvalidDatabaseConnection을 던져줘야 함
	 */
	public static function getConnection($name = 'default')
	{
		if(isset(self::$connection[$name]))
		{
			return self::$connection[$name];
		}


		throw new DatabaseException();
	}

	/**
	 * 새로운 DB 접속을 엽니다
	 * @param string $name 별칭
	 * @param string $host
	 * @param string $username
	 * @param string $password
	 * @param string $database
	 * @param int $port
	 */
	public static function openConnection($name = '', $host, $username, $password, $database, $port = 3306)
	{
		// 이름을 정하지 않았다면
		if(!$name)
		{
			return FALSE;
			/**
			 * @todo return false 대신에 exception 추가
			 */
		}

		self::$connection[$name] = new DatabaseConnection($host, $usernae, $password, $database, $port);

		/**
		 * @todo DB 접속 성공 여부와 관계없이 항상 return true 하는 점을 개선해야 함
		 */
		return TRUE;
	}

	/**
	 * default 커넥션에 쿼리 실행
	 * @param string $query 실행할 쿼리
	 */
	public static function query($query)
	{
		return self::getConnection('default')->query($query);
	}

	public static function fetch($result)
	{
		return self::getConnection('default')->fetch_object();
	}
}