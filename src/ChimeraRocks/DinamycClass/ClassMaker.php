<?php

namespace ChimeraRocks\DinamycClass;

use ChimeraRocks\DinamycClass\Exception\SetterMethodNotFoundException;

class ClassMaker 
{

	private $builder;
	private $objects = [];

	public function __construct($builder) 
	{
		$this->builder = $builder;		
	}

	public function make($class, $count = null) 
	{
		$configurations = $this->builder->getConfigurations();
		
		foreach (range(1, $count ? $count : 1) as $number) {
			$object = new $class;
			foreach ($configurations[$class] as $property => $value) {
				$exploded = explode('_', $property);
				$properties = [];
				foreach($exploded as $parts) {
				    $properties[] = ucfirst($parts);
				}

				$imploded = implode('',$properties);
				$setter = 'set' . $imploded;

				try {
					$object->$setter($value);
				} catch (\Error $e) {
					throw new SetterMethodNotFoundError("Class $class has not method $setter", 1);
				}
			}
			$this->objects[] = $object;
		}
		
		return $this;
	}

	public function each($callback)
	{
		foreach ($this->objects as $model) {
			$callback($model);
		}
		return $this;
	}

	public function create()
	{
		if (count($this->objects) == 1) {
			return $this->objects[0];
		}
		return $this->objects;
	}

}