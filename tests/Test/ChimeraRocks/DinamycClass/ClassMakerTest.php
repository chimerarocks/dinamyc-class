<?php

namespace Test\ChimeraRocks\DinamycClass;

use ChimeraRocks\DinamycClass\ClassBuilder;
use ChimeraRocks\DinamycClass\ClassMaker;
use PHPUnit\Framework\TestCase;
use Test\Stubs\Model;
use Mockery;

class ClassMakerTest extends TestCase
{

	private function getClassMaker($configurations = [])
	{
		if (empty($configurations)) {
			$configurations = [
				'name' => 'Test',
				'description' => 'Description'
			];	
		}		

		$mockBuilder = Mockery::mock(ClassBuilder::class)
			->shouldReceive('getConfigurations')
			->andReturn([
				Model::class => $configurations
			])->getMock();

		$maker = new ClassMaker($mockBuilder);

		return $maker;
	}

	public function test_can_make_a_object_relative_to_a_class_and_should_returns_a_object_when_creating_one()
	{
		$maker = $this->getClassMaker();		

		$result = $maker->make(Model::class);

		//should not return the objects, that will be returned with create()
		$this->assertInstanceOf(ClassMaker::class, $result);

		$model = $result->create();
		
		$this->assertInstanceOf(Model::class, $model);
		$this->assertEquals('Test', $model->getName());
		$this->assertEquals('Description', $model->getDescription());
	}

	public function test_can_make_many_objects_relative_to_a_class_and_should_returns_a_array_when_creating_many()
	{
		$maker = $this->getClassMaker();
		
		$result = $maker->make(Model::class,5);

		//should not return the objects, that will be returned with create()
		$this->assertInstanceOf(ClassMaker::class, $result);

		$objects = $result->create();
		
		$this->assertCount(5, $objects);

		$model = $objects[4];
		$this->assertInstanceOf(Model::class, $model);
		$this->assertEquals('Test', $model->getName());
		$this->assertEquals('Description', $model->getDescription());
	}

	public function test_can_change_attributes_of_elements_dinamically_after_creation()
	{
		$maker = $this->getClassMaker();

		$i = 1;

		$result = $maker->make(Model::class,5)->each(function($object) use (&$i) {
			$object->setDescription('Description' . $i++);
		});

		//should not return the objects, that will be returned with create()
		$this->assertInstanceOf(ClassMaker::class, $result);

		$objects = $result->create();
		
		$this->assertCount(5, $objects);

		$model = $objects[0];
		$this->assertInstanceOf(Model::class, $model);
		$this->assertEquals('Test', $model->getName());
		$this->assertEquals('Description1', $model->getDescription());
		$this->assertEquals('Description1', $model->getDescription());

		$model = $objects[1];
		$this->assertEquals('Description2', $model->getDescription());
		$model = $objects[2];
		$this->assertEquals('Description3', $model->getDescription());
		$model = $objects[3];
		$this->assertEquals('Description4', $model->getDescription());
		$model = $objects[4];
		$this->assertEquals('Description5', $model->getDescription());
	}

	public function test_can_change_attributes_of_elements_dinamically_after_creation_of_one_object()
	{
		$maker = $this->getClassMaker();

		$i = 1;

		$result = $maker->make(Model::class)->each(function($object) use (&$i) {
			$object->setDescription('Description' . $i++);
		});

		//should not return the objects, that will be returned with create()
		$this->assertInstanceOf(ClassMaker::class, $result);

		$model = $result->create();
		
		$this->assertInstanceOf(Model::class, $model);
		$this->assertEquals('Test', $model->getName());
		$this->assertEquals('Description1', $model->getDescription());
	}


	public function test_can_create_object_dinamically_when_attributes_are_in_sneak_case()
	{
		$maker = $this->getClassMaker([
				'name' => 'Name',
				'Description' => 'Description',
				'data_update' => '2009-15-12'
			]);


		$result = $maker->make(Model::class);

		//should not return the objects, that will be returned with create()
		$this->assertInstanceOf(ClassMaker::class, $result);

		$model = $result->create();
		
		$this->assertInstanceOf(Model::class, $model);
		$this->assertEquals('Name', $model->getName());
		$this->assertEquals('Description', $model->getDescription());
		$this->assertEquals('2009-15-12', $model->getDataUpdate());

	}

	/**
	 * @expectedException \ChimeraRocks\DinamycClass\Exception\SetterMethodNotFoundError
	 */
	public function test_should_throws_exception_when_set_method_not_found()
	{
		$maker = $this->getClassMaker([
				'id' => 1,
				'name' => 'Name',
				'Description' => 'Description',
				'data_update' => '2009-15-12'
			]);


		$result = $maker->make(Model::class);

		//should not return the objects, that will be returned with create()
		$this->assertInstanceOf(ClassMaker::class, $result);

		$model = $result->create();
		
		$this->assertInstanceOf(Model::class, $model);
		$this->assertEquals('Name', $model->getName());
		$this->assertEquals('Description', $model->getDescription());
		$this->assertEquals('2009-15-12', $model->getDataUpdate());
	}
}