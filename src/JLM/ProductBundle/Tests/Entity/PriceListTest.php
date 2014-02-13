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
		//$this->markTestIncomplete();
		$this->public = 229.5;
		$this->entity = new PriceList(229.5);
		
		$this->price = 152;

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
	public function testAddWithPriceInterface()
	{
		$pi = $this->getMock('JLM\ProductBundle\Model\PriceInterface');
		$pi->expects($this->once())->method('getValue')->will($this->returnValue(42)); 
		$this->entity->add(5, $pi);
		$this->assertSame(42, $this->entity->get(5));
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
		$this->entity->add(8, 52.4);
		$this->entity->add(5, $this->price);
		$this->assertSame($this->price, $this->entity->get(7));
		
	}
	
	/**
	 * @test
	 */
	public function testGetValue()
	{
		$this->assertSame($this->public, $this->entity->getValue());
	}
	
	/**
	 * @test
	 */
	public function testGetCurrency()
	{
		$this->assertSame('€', $this->entity->getCurrency());
	}
	
	/**
	 * @test
	 */
	public function test__toString()
	{
		$this->assertSame($this->public.' €', $this->entity->__toString());
	}
	
	/**
	 * @test
	 */
	public function test__constructWithPriceInterface()
	{
		$pi = $this->getMock('JLM\ProductBundle\Model\PriceInterface');
		$pi->expects($this->once())
			->method('getValue')
			->will($this->returnValue(45.2));
		$pl = new PriceList($pi);
		$this->assertSame(45.2, $pl->getValue());
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
	
	/**
	 * @test
	 */
	public function testDoubleAddSameQuantity()
	{
		$this->entity->add(5, 48);
		$this->entity->add(5, 32);
		$this->assertCount(2, $this->entity);
		$this->assertSame(32, $this->entity->get(5));
	}
	
	/**
	 * @test
	 */
	public function testRemoveNonExistantQuantity()
	{
		$this->entity->remove(11);
		$this->assertCount(1, $this->entity);
	}
	
	/**
	 * @test
	 */
	public function testDontCanRemovePublicPrice()
	{
		$this->entity->remove(0);
		$this->assertCount(1, $this->entity);
	}
	
	/**
	 * @test
	 */
	public function testNegativeQuantityConvertedToPositiveValue()
	{
		$this->entity->add(-15.2, 12);
		$this->assertSame(12, $this->entity->get(16));
	}
}