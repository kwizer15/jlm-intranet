<?php
namespace JLM\ProductBundle\Tests\Entity;

use JLM\ProductBundle\Entity\PurchasableProduct;

class PurchasableProductTest extends \PHPUnit_Framework_TestCase
{
	protected $entity;
	
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->publicPrice = 650.45;
		$this->supplier = $this->getMock('JLM\ProductBundle\Model\SupplierInterface');
		$this->product = $this->getMock('JLM\ProductBundle\Model\ProductInterface');
		$this->entity = new PurchasableProduct($this->product, $this->supplier, $this->publicPrice);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertInstanceOf('JLM\ProductBundle\Model\ProductInterface', $this->entity);
		$this->assertInstanceOf('JLM\ProductBundle\Model\PurchasableInterface', $this->entity);
	}
	
	/**
	 * @test
	 */
	public function test__constructWithUnity()
	{
		$entity = new PurchasableProduct($this->product, $this->supplier, $this->publicPrice, 'foo');
		$this->assertSame('foo', $entity->getPurchaseUnity());
	}
	
	/**
	 * @test
	 */
	public function testGetSupplier()
	{
		$this->assertSame($this->supplier, $this->entity->getSupplier());
	}
	
	/**
	 * @test
	 */
	public function testGetPublicPrice()
	{
		$this->assertSame($this->publicPrice, $this->entity->getPublicPrice());
	}
	
	/**
	 * @test
	 */
	public function testSetPublicPrice()
	{
		$this->entity->setPublicPrice(85);
		$this->assertSame(85, $this->entity->getPublicPrice());
	}
	
	/**
	 * @test
	 */
	public function testGetPurchaseUnitPrice()
	{
		$this->assertSame($this->publicPrice, $this->entity->getPurchaseUnitPrice(50));
	}
	
	/**
	 * @test
	 */
	public function testAddPurchaseUnitPrice()
	{
		$this->assertSame($this->entity, $this->entity->addPurchaseUnitPrice(5,520));
	}
	
	/**
	 * @test
	 */
	public function testRemovePurchaseUnitPrice()
	{
		$this->entity->addPurchaseUnitPrice(5,520);
		$this->entity->addPurchaseUnitPrice(10,420);
		$this->entity->removePurchaseUnitPrice(5);
		$this->assertSame($this->publicPrice, $this->entity->getPurchaseUnitPrice(7));
	}
	
	/**
	 * @test
	 */
	public function testGetPurchaseUnity()
	{
		$this->assertNull($this->entity->getPurchaseUnity());
	}
	
	/**
	 * @test
	 */
	public function testGetPurchaseUnitPriceWithQuantity()
	{
		$this->entity->addPurchaseUnitPrice(5,520);
		$this->assertSame(520, $this->entity->getPurchaseUnitPrice(8));
	}
}