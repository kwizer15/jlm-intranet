<?php
namespace JLM\ProductBundle\Tests\Entity;

use JLM\ProductBundle\Entity\PriceList;

class PriceListTest extends \PHPUnit_Framework_TestCase
{
	protected $entity;
	
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->markTestIncomplete();
		$this->public = $this->getMock('JLM\ProductBundle\Model\PriceInterface');
		$this->entity = new PriceList($this->public);
		
		$this->price = $this->getMock('JLM\ProductBundle\Model\PriceInterface');

	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertSame($this->public, $this->entity->get(7));
	}
	
	/**
	 * @test
	 */
	public function testAdd()
	{
		$this->entity->add(5, $this->price);
		$this->assertCount(2, $this->entity);
	}
	
	/**
	 * @test
	 */
	public function testRemove()
	{
		$this->entity->add(5, $this->price);
		$this->entity->remove(5);
		$this->assertCount(1, $this->entity);
	}
	
	/**
	 * @test
	 */
	public function testGet()
	{
		$this->entity->add(8, $this->getMock('JLM\ProductBundle\Model\PriceInterface'));
		$this->entity->add(5, $this->price);
		$this->assertSame($this->price, $this->entity->get(7));
	}
	
	/**
	 * @test
	 */
	public function testGetPublic()
	{
		$this->assertSame($this->public, $this->entity->getPublic());
	}
	
	/**
	 * @test
	 */
	public function testIterator()
	{
		foreach ($this->entity as $price)
		{
			$this->assertInstanceOf('JLM\ProductBundle\Model\PriceInterface', $price);
		}
	}
}