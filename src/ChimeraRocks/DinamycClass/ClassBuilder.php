<?php

namespace ChimeraRocks\DinamycClass;

class ClassBuilder {

	private $configurations = [];
	private $objects = [];

	public function build($class, $configurations) 
	{
		$this->configurations[$class] = $configurations;
		return $this;	
	}

	public function getConfigurations()
	{
		return $this->configurations;
	}

}