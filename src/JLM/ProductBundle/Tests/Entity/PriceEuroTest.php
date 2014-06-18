<?php
namespace JLM\ProductBundle\Tests\Entity;

use JLM\ProductBundle\Entity\PriceEuro;

class PriceEuroTest extends \PHPUnit_Framework_TestCase
{
	protected $entity;
	
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->entity = new PriceEuro(82.35);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertInstanceOf('JLM\ProductBundle\Model\PriceInterface', $this->entity);
	}
	
	/**
	 * @test
	 */
	public function testGetValue()
	{
		$this->assertSame(82.35, $this->entity->getValue());
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
		$this->assertSame('82.35 €', $this->entity->__toString());
	}
}