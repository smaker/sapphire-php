<?php

class Permission
{
	private $instanceId;
	private $permissionKey;

	public function __construct($instanceId = null)
	{
		$this->instanceId = $instanceId;
	}

	public function key($permissionKey)
	{
		$this->permissionKey = $permissionKey;

		return $this;
	}

	public function value()
	{
		return $this;
	}

	public function create()
	{
		$data = array(
			'instanceId' => $this->instanceId
		);

		$this->db->insert('st_instance_permission', $data);

		return true;
	}
}
