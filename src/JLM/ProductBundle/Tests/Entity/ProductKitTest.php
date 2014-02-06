<?php
namespace JLM\ProductBundle\Tests\Entity;

use JLM\ProductBundle\Entity\ProductKit;

class ProductKitTest extends \PHPUnit_Framework_TestCase
{
	protected $entity;
	
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->entity = new ProductKit($this->getMock('JLM\ProductBundle\Model\ProductInterface'));
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertInstanceOf('JLM\ProductBundle\Model\ProductInterface', $this->entity);
		$this->assertInstanceOf('JLM\ProductBundle\Model\ProductKitInterface', $this->entity);
		
		$this->assertCount(0,$this->entity->getSubProducts());
	}
	
	public function testAddSubProduct()
	{
		$this->entity->addSubProduct($this->getMock('JLM\ProductBundle\Model\ProductInterface'));
		$this->assertCount(1,$this->entity->getSubProducts());
	}
	
	/**
	 * @depends testAddSubProduct
	 */
	public function testRemoveSubProduct()
	{
		$mock = $this->getMock('JLM\ProductBundle\Model\ProductInterface');
		$this->entity->addSubProduct($mock);
		$this->entity->addSubProduct($this->getMock('JLM\ProductBundle\Model\ProductInterface'));
		$this->entity->removeSubProduct($mock);
		$this->assertCount(1,$this->entity->getSubProducts());
	}
}