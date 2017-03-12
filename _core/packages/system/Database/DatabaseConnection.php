<?php
/**
 * @package Core\DatabaseConnection
 */
namespace Core;

/**
 * 여러 개의 DB에 접속했을 때 각각의 DB를 다루기 위한 connection class
 * @class DatabaseConnection
 */
class DatabaseConnection
{
	private $mysqli;

	private $action = 'SELECT';
	private $columns = '*';
	private $from = array();

	private $_where_cache = array();
	private $limit = array();
	private $orderBy;

	/**
	 * DB 접속
	 * @param string $host		DB 호스트네임
	 * @param string $username	DB 사용자 이름
	 * @param string $password	DB사용자 비밀번호
	 * @param string $database	접속할 데이터베이스
	 * @param int 	 $port		DB 접속 포트 번호
	 * @return void
	 */
	public function __construct($host, $username, $password, $database, $port = 3306)
	{
		$this->mysqli = new \mysqli($host, $username, $password, $database, $port);

		// 접속 에러가 발생한 경우
		if($this->mysqli->connect_error)
		{
			if($this->mysqli->connect_errno == 1045)
			{
				$message = 'DB 접속 정보가 잘못되었습니다.';
			}
			else
			{
				$message = 'DB 접속 실패 : ' . $this->mysqli->connect_error;
			}

			throw new Database\FailedDatabaseConnection($message);
		}
	}

	/**
	 * DB 접속 닫기
	 * @return void
	 */
	public function __destruct()
	{
		$this->mysqli->close();
	}

	/**
	 * 쿼리 실행
	 * @return \mysqli|bool
	 */
	public function query($query)
	{
		$result = $this->mysqli->query($query);

		// 에러가 발생했다면
		if($result == FALSE)
		{
			\Core\Response::error($this->mysqli->error);
			return FALSE;
		}

		return $result;
	}

	/**
	 * SELECT 쿼리 생성
	 * @param string|array $columns
	 * @return DatabaseConnection
	 */
	public function select($columns = '*')
	{
		$this->action = 'SELECT';
		$this->_where_cache = array();
		$this->columns = $columns;
		$this->from = '';
		$this->limit = array();

		return $this;
	}

	/**
	 * FROM절 생성
	 * @param string|array $tables
	 * @return DatabaseConnection
	 */
	public function from($tables)
	{
		$this->from = $tables;
		return $this;
	}

	/**
	 * WHERE절 생성
	 *
	 * @param string|array $key 칼럼
	 * @return DatabaseConnection
	 */
	public function where($key, $data = NULL)
	{
		$operator = '';
		if(count($this->_where_cache) > 0)
		{
			$operator = ' AND ';
		}

		if(is_array($key))
		{
			foreach($key as $column => $value)
			{
				if(count($this->_where_cache) > 0)
				{
					$operator = 'AND ';
				}

				if(!is_array($value))
				{
					$value = array($value);
				}

				$value = $this->escape($value);

				$this->_where_cache[] = $operator . $this->escapeColumn($column) . ' = ' . implode(', ', $value);
			}
		}
		else
		{
			if(!is_array($data))
			{
				$data = array($data);
			}

			$data = $this->escape($data);

			$this->_where_cache[] = $operator . $this->escapeColumn($key) . ' = ' . implode(', ', $data) . '';
		}

		return $this;
	}
	
	/**
	 * WHERE절 생성
	 *
	 * @param string|array $key 칼럼
	 *
	 * @return DatabaseConnection
	 */
	public function whereIn($key, $data = NULL)
	{
		$operator = '';
		if(count($this->_where_cache) > 0)
		{
			$operator = ' AND ';
		}

		if(is_array($key))
		{
			foreach($key as $column => $value)
			{
				if(count($this->_where_cache) > 0)
				{
					$operator = 'AND ';
				}

				if(!is_array($value))
				{
					$value = array($value);
				}
				
				$value = $this->escape($value);

				$this->_where_cache[] = $operator . $this->escapeColumn($column) . ' IN (' . implode(', ', $value) . ')';
			}
		}
		else
		{
			if(!is_array($data))
			{
				$data = array($data);
			}

			$data = $this->escape($data);

			$this->_where_cache[] = $operator . $this->escapeColumn($key) . ' IN (' . implode(', ', $data) . ')';
		}

		return $this;
	}

	public function limit($limitStart, $limitEnd = NULL)
	{
		$this->limit[] = $limitStart;
		if($limitEnd)
		{
			$this->limit[] = $limitEnd;
		}

		return $this;
	}

	public function orderBy($orderBy)
	{
		$this->orderBy = $orderBy;
		return $this;
	}

	public function clear()
	{
		$this->action = 'SELECT';
		$this->columns = array();
		$this->from = array();
		$this->_where_cache = array();
		$this->limit = array();
	}

	public function update($from, $data = NULL)
	{
		$this->action = 'UPDATE';
		$this->from = $from;
		if($data !== NULL)
		{
			$this->data = $data;
		}

		$this->get();

		return $this;
	}

	public function insert($from, $data = NULL)
	{
		$this->action = 'INSERT';
		$this->from = $from;
		if($data !== NULL)
		{
			$this->data = $data;
		}

		$this->get();

		return $this;
	}

	public function delete($table, $where = NULL)
	{
		$this->action = 'DELETE';
		$this->from = $table;
		if($where !== NULL)
		{
			$this->where($where);
		}

		$this->get();
		return $this;
	}

	/**
	 * 서브 쿼리
	 * @todo 서브 쿼리 구현
	 */
	public function subQuery()
	{

	}

	/**
	 * 쿼리 실행하기
	 */
	public function get()
	{
		switch ($this->action)
		{
			// SELECT 쿼리
			case 'SELECT':
				$query = 'SELECT %s FROM %s';
				if(is_array($this->columns))
				{
					$columns = array();
					foreach($this->columns as $column => $alias)
					{
						if(is_numeric($column))
						{
							$columns[] = $this->escapeColumn($alias);
						}
						else
						{
							$columns[] = $this->escapeColumn($column) . ' as ' . $this->escapeColumn($alias);
						}
					}
					$columns = implode(',', $columns);
				}
				else
				{
					$columns = $this->escapeColumn($this->columns);
				}

				$from = $this->escapeColumn($this->from);

				if(count($this->_where_cache) > 0)
				{
					$query .= ' WHERE ';
					$query .= implode(' ', $this->_where_cache);
				}

				$query = sprintf($query, $columns, $from);

				if($this->orderBy)
				{
					$query .= ' ORDER BY ' . $this->orderBy;
				}

				if(count($this->limit) > 0)
				{
					if(count($this->limit) == 2)
					{
						$query .= ' LIMIT ' . $this->limit[0] . ', ' . $this->limit[1];
					}
					else
					{
						$query .= ' LIMIT ' . $this->limit[0];
					}
				}

				break;
			// INSERT 쿼리
			case 'INSERT':
				$query = 'INSERT INTO ' . $this->escapeColumn($this->from);

				$columns = array_keys($this->data);

				foreach($columns as &$column)
				{
					$column = $this->escapeColumn($column);
				}

				$query .= ' (' . implode(', ', $columns) . ')';

				$values = array_values($this->data);

				foreach($values as &$value)
				{
					$value = '"' . addslashes($value) . '"';
				}

				$query .= ' VALUES (' . implode(', ', $values) . ')';

				break;
			// UPDATE 쿼리
			case 'UPDATE':
				$query = 'UPDATE ' . $this->escapeColumn($this->from);
				$query .= ' SET ';
				$value = array();

				foreach($this->data as $column => $data)
				{
					$value[] = $this->escapeColumn($column) . ' = "' . addslashes($data) . '"';
				}
				$query .= implode(' , ', $value);

				if(count($this->_where_cache) > 0)
				{
					$query .= ' WHERE ';
					$query .= implode(' ', $this->_where_cache);
				}

				break;
			// delete
			case 'DELETE':
				$query = 'DELETE FROM ' . $this->escapeColumn($this->from);

				if(count($this->_where_cache) > 0)
				{
					$query .= ' WHERE ';
					$query .= implode(' ', $this->_where_cache);
				}

				break;
		}
		
		$this->_where_cache = array();

		return $this->query($query);
	}

	public function getOne()
	{
		return $this->get()->fetch_object();
	}
	
	public function escape($str)
	{
		if(is_array($str))
		{
			foreach($str as $key => $value)
			{
				$str[$key] = $this->escape($value);
			}
			
			return $str;
		}

		return "'" . str_replace("'", "''", $str) . "'";
	}

	public function escapeColumn($column)
	{
		if($column == '*')
		{
			return '*';
		}

		if(preg_match('/([a-zA-Z0-9_]+)\((.*)\)/', $column, $matches))
		{
			return $matches[1] . '(' . $this->escapeColumn($matches[2]) . ')';
		}

		if(strpos($column, '.') !== FALSE)
		{
			$parts = explode('.', $column);
			foreach($parts as $key => $part)
			{
				if($part == '*')
				{
					continue;
				}

				$parts[$key] = '`' . $column . '`';
			}

			return implode('.', $parts);
		}

		return '`' . $column . '`';
	}

	/**
	 * 마지막으로 발생한 에러 반환
	 * @return string
	 */
	public function getError()
	{
		return $this->mysqli->error;
	}

	public function fetch($result)
	{
		return $result->fetch_object();
	}
	
	/**
	 * mysqli 객체의 last_insert_id 반환
	 *
	 * @return string
	 */
	public function getLastInsertId()
	{
		return $this->mysqli->insert_id;
	}
}