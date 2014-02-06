<?php
namespace JLM\ProductBundle\Tests\Entity;

class PriceDecoratorTest extends \Kwizer\DesignPatternBundle\Test\DecoratorTestCase
{
	/**
	 * {@inheritdoc}
	 */
	protected function getInterfaceName()
	{
		return 'JLM\ProductBundle\Model\PriceInterface';
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getDecoratorName()
	{
		return 'JLM\ProductBundle\Entity\PriceDecorator';
	}
	
	/**
	 * @test
	 */
	public function testGetValue()
	{
		$this->assertDecoratorMethod('getValue', 52.30);
	}
	
	/**
	 * @test
	 */
	public function testGetCurrency()
	{
		$this->assertDecoratorMethod('getCurrency', '$');
	}
	
	/**
	 * @test
	 */
	public function test__toString()
	{
		$this->assertDecoratorMethod('__toString', '52.30 $');
	}
}