<?php

namespace Test\Stubs;

class Model
{
	private $id;

	private $name;

	private $description;

	private $data_update;


	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getDataUpdate()
	{
		return $this->data_update;
	}

	public function setDataUpdate($data_update)
	{
		$this->data_update = $data_update;
	}
}