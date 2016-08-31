<?php

namespace Test\ChimeraRocks\DinamycClass;

use ChimeraRocks\DinamycClass\ClassBuilder;
use PHPUnit\Framework\TestCase;
use Test\Stubs\Model;

class ClassBuilderTest extends TestCase
{
	public function test_can_store_a_configuration_to_a_relative_class()
	{
		$builder = new ClassBuilder();

		$configurations = [
			'name' => 'Test',
			'description' => 'Description'
		];
		
		$result = $builder->build(Model::class, $configurations);
		
		$this->assertInstanceOf(ClassBuilder::class, $result);

		$configurationsBuilder = $builder->getConfigurations();
		$expectedconfigurations = [
			Model::class => [
				'name' => 'Test',
				'description' => 'Description'
			]
		];

		$this->assertCount(1, $configurationsBuilder);
		$this->assertEquals($expectedconfigurations, $configurationsBuilder);
	}
}