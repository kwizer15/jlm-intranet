<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\Address;

class AddressTest extends \PHPUnit_Framework_TestCase
{
	protected $entity;
	
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->city = $this->getMock('JLM\ContactBundle\Model\CityInterface');
		
		$this->city->expects($this->any())
				   ->method('getName')
				   ->will($this->returnValue('Saint-Soupplets'));
		
		$this->city->expects($this->any())
				   ->method('getZip')
				   ->will($this->returnValue('77165'));
		
		$this->city->expects($this->any())
				   ->method('getCountry')
				   ->will($this->returnValue('France'));
		
		$this->city->expects($this->any())
				   ->method('__toString')
				   ->will($this->returnValue('77165 - Saint-Soupplets'));
		
		$this->entity = new Address('17, avenue de Montboulon',$this->city);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertNull($this->entity->getId());
		$this->assertSame('Saint-Soupplets',$this->entity->getCity());
		$this->assertSame('77165',$this->entity->getZip());
		$this->assertSame('France',$this->entity->getCountry());
	}
	
	public function providerStreet()
	{
		return array(
				array('',''),
				array('1, rue Bidule Machin Truc','1, rue Bidule Machin Truc'),
				array(153,'153'),
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerStreet
	 */
	public function testSetStreet($in)
	{
		$this->assertSame($this->entity,$this->entity->setStreet($in));
	}
	
	/**
	 * @test
	 * @dataProvider providerStreet
	 * @depends testSetStreet
	 */
	public function testGetStreet($in,$out)
	{
		$this->entity->setStreet($in);
		$this->assertSame($out,$this->entity->getStreet());
	}
	
	/**
	 * @test
	 */
	public function testSetCity()
	{
		$this->assertSame($this->entity,$this->entity->setCity($this->getMock('JLM\ContactBundle\Model\CityInterface')));
	}
	
	public function providerCity()
	{
		return array(
				array('Othis'),
				array('Dammartin'),
				array('Paris 16')
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerCity
	 */
	public function testGetCity($in)
	{
		$city = $this->getMock('JLM\ContactBundle\Model\CityInterface');
		$city->expects($this->once())->method('getName')->will($this->returnValue($in));
		$this->entity->setCity($city);
		$this->assertSame($in,$this->entity->getCity());
	}
	
	public function providerZip()
	{
		return array(
				array('25301'),
				array('77280'),
				array('52130')
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerZip
	 */
	public function testGetZip($in)
	{
		$city = $this->getMock('JLM\ContactBundle\Model\CityInterface');
		$city->expects($this->once())->method('getZip')->will($this->returnValue($in));
		$this->entity->setCity($city);	
		$this->assertSame($in,$this->entity->getZip());
	}
	
	/**
	 * @test
	 */
	public function test__toString()
	{	
		$this->assertSame('17, avenue de Montboulon'.chr(10).'77165 - Saint-Soupplets',$this->entity->__toString());
	}

}