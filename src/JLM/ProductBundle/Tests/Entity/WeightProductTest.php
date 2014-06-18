<?php
namespace JLM\ProductBundle\Tests\Entity;

use JLM\ProductBundle\Entity\WeightProduct;

class WeightProductTest extends \PHPUnit_Framework_TestCase
{
	protected $entity;
	
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->weight = 650.45;
		$this->product = $this->getMock('JLM\ProductBundle\Model\ProductInterface');
		$this->entity = new WeightProduct($this->product, $this->weight);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertInstanceOf('JLM\ProductBundle\Model\ProductInterface', $this->entity);
		$this->assertInstanceOf('JLM\ProductBundle\Model\WeightInterface', $this->entity);
	}
	
	/**
	 * @test
	 */
	public function testGetWeight()
	{
		$this->assertSame($this->weight, $this->entity->getWeight());
	}
	
	/**
	 * @test
	 */
	public function testSetWeight()
	{
		$this->assertSame($this->entity, $this->entity->setWeight(520));
	}
}