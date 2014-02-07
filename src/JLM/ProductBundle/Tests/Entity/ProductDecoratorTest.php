<?php
namespace JLM\ProductBundle\Tests\Entity;

use JLM\ProductBundle\Entity\PriceDecorator;

class ProductDecoratorTest extends \Kwizer\DesignPatternBundle\Test\DecoratorTestCase
{
	/**
	 * {@inheritdoc}
	 */
	protected function getInterfaceName()
	{
		return 'JLM\ProductBundle\Model\ProductInterface';
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getDecoratorName()
	{
		return 'JLM\ProductBundle\Entity\ProductDecorator';
	}
	
	/**
	 * @test
	 */
	public function testGetReference()
	{
		$this->assertDecoratorMethod('getReference', 'REFERENCE123');
	}
	
	/**
	 * @test
	 */
	public function testGetDesignation()
	{
		$this->assertDecoratorMethod('getDesignation', 'Désignation comme ça');
	}
	
	/**
	 * @test
	 */
	public function testGetDescription()
	{
		$this->assertDecoratorMethod('getDescription', 'Description comme ça');
	}
	
	/**
	 * @test
	 */
	public function testSetReference()
	{
		$this->interface->expects($this->once())
					->method('setReference');
		$this->entity->setReference('REFERENCE');
	}
	
	/**
	 * @test
	 */
	public function testSetDesignation()
	{
		$this->interface->expects($this->once())
					->method('setDesignation');
		$this->entity->setDesignation('Designation');
	}
	
	/**
	 * @test
	 */
	public function testSetDescription()
	{
		$this->interface->expects($this->once())
					->method('setDescription');
		$this->entity->setDescription('Description');
	}
	
	/**
	 * @test
	 */
	public function test__toString()
	{
		$this->assertDecoratorMethod('__toString', 'Autre nom de produit');
	}
}