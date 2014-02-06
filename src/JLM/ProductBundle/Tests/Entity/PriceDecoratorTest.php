<?php
namespace JLM\ProductBundle\Tests\Entity;

use JLM\ProductBundle\Entity\PriceDecorator;

class PriceDecoratorTest extends \PHPUnit_Framework_TestCase
{
	protected $entity;
	
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->price = $this->getMock('JLM\ProductBundle\Model\PriceInterface');
		$this->entity = $this->getMockForAbstractClass('JLM\ProductBundle\Entity\PriceDecorator',array($this->price));
		
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
		$value = 52.30;
		$this->price->expects($this->once())
					->method('getValue')
					->will($this->returnValue($value));
		
		$this->assertSame($value, $this->entity->getValue());
	}
	
	/**
	 * @test
	 */
	public function testGetCurrency()
	{
		$value = '$';
		$this->price->expects($this->once())
		->method('getCurrency')
		->will($this->returnValue($value));
	
		$this->assertSame($value, $this->entity->getCurrency());
	}
	
	/**
	 * @test
	 */
	public function test__toString()
	{
		$value = '52.30 $';
		$this->price->expects($this->once())
		->method('__toString')
		->will($this->returnValue($value));
	
		$this->assertSame($value, $this->entity->__toString());
	}
}