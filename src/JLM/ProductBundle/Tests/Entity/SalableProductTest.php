<?php
namespace JLM\ProductBundle\Tests\Entity;

use JLM\ProductBundle\Entity\SalableProduct;

class SalableProductTest extends \PHPUnit_Framework_TestCase
{
	protected $entity;
	
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->basePrice = 650.45;
		$this->product = $this->getMock('JLM\ProductBundle\Model\ProductInterface');
		$this->entity = new SalableProduct($this->product, $this->basePrice);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertInstanceOf('JLM\ProductBundle\Model\ProductInterface', $this->entity);
		$this->assertInstanceOf('JLM\ProductBundle\Model\SalableInterface', $this->entity);
	}
	
	/**
	 * @test
	 */
	public function test__constructWithUnity()
	{
		$entity = new SalableProduct($this->product, $this->basePrice, 'foo');
		$this->assertSame('foo', $entity->getSellUnity());
	}
	
	/**
	 * @test
	 */
	public function testGetSellUnitPrice()
	{
		$this->assertSame($this->basePrice, $this->entity->getSellUnitPrice());
	}
	
	/**
	 * @test
	 */
	public function testAddSellUnitPrice()
	{
		$this->assertSame($this->entity, $this->entity->addSellUnitPrice(5,520));
	}
	
	/**
	 * @test
	 */
	public function testRemoveSellUnitPrice()
	{
		$this->entity->addSellUnitPrice(5,520);
		$this->entity->addSellUnitPrice(10,420);
		$this->entity->removeSellUnitPrice(5);
		$this->assertSame($this->basePrice, $this->entity->getSellUnitPrice(7));
	}
	
	/**
	 * @test
	 */
	public function testGetSellUnity()
	{
		$this->assertNull($this->entity->getSellUnity());
	}
	
	/**
	 * @test
	 */
	public function testGetSellUnitPriceWithQuantity()
	{
		$this->entity->addSellUnitPrice(5,520);
		$this->assertSame(520, $this->entity->getSellUnitPrice(8));
	}
}