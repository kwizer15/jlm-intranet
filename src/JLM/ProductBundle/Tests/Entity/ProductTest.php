<?php
namespace JLM\ProductBundle\Tests\Entity;

use JLM\ProductBundle\Entity\Product;

class ProductTest extends \PHPUnit_Framework_TestCase
{
	protected $entity;
	
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->entity = new Product;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertInstanceOf('JLM\ProductBundle\Model\ProductInterface', $this->entity);
	}
	
	public function dataReference()
	{
		return array(
			array('SAV005', 'SAV005'),
		);
	}
	
	/**
	 * @test
	 * @dataProvider dataReference
	 */
	public function testSetReference($in)
	{
		$this->assertSame($this->entity, $this->entity->setReference($in));
	}
	
	/**
	 * @test
	 * @dataProvider dataReference
	 * @depends testSetReference
	 */
	public function testGetReference($in, $out)
	{
		$this->entity->setReference($in);
		$this->assertSame($out, $this->entity->getReference());
	}
	
	public function dataDesignation()
	{
		return array(
			array('Ampli de barre palpeuse Ventimiglia NS', 'Ampli de barre palpeuse Ventimiglia NS'),
		);
	}
	
	/**
	 * @test
	 * @dataProvider dataDesignation
	 */
	public function testSetDesignation($in)
	{
		$this->assertSame($this->entity, $this->entity->setDesignation($in));
	}
	
	/**
	 * @test
	 * @dataProvider dataDesignation
	 * @depends testSetDesignation
	 */
	public function testGetDesignation($in, $out)
	{
		$this->entity->setDesignation($in);
		$this->assertSame($out, $this->entity->getDesignation());
	}
	
	public function dataDescription()
	{
		return array(
				array('Ampli de barre palpeuse Ventimiglia NS', 'Ampli de barre palpeuse Ventimiglia NS'),
		);
	}
	
	/**
	 * @test
	 * @dataProvider dataDescription
	 */
	public function testSetDescription($in)
	{
		$this->assertSame($this->entity, $this->entity->setDescription($in));
	}
	
	/**
	 * @test
	 * @dataProvider dataDescription
	 * @depends testSetDescription
	 */
	public function testGetDescription($in, $out)
	{
		$this->entity->setDescription($in);
		$this->assertSame($out, $this->entity->getDescription());
	}
	
	/**
	 * @test
	 * @dataProvider dataDesignation
	 * @depends testSetDesignation
	 */
	public function test__toString($in, $out)
	{
		$this->entity->setDesignation($in);
		$this->assertSame($out, $this->entity->__toString());
	}
}