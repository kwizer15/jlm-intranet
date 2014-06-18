<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\City;
use JLM\ContactBundle\Entity\CountryInterface;

class CityTest extends \PHPUnit_Framework_TestCase
{
	protected $entity;
	
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->country = $this->getMock('JLM\ContactBundle\Model\CountryInterface');
		$this->entity = new City('Othis',77280,$this->country);
		
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertSame('Othis',$this->entity->getName());
		$this->assertSame('77280',$this->entity->getZip());
		$this->assertSame($this->country,$this->entity->getCountry());
		$this->assertNull($this->entity->getId());
	}

	public function providerName()
	{
		return array(
				array('paris','Paris'),
				array('MONTPELLIER','Montpellier'),
				array('bouLOgNe-biLLancOuRt','Boulogne-Billancourt'),
				array('Paris 13 Buttes-Chaumonts','Paris 13 Buttes-Chaumonts'),
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerName
	 */
	public function testSetName($in, $out)
	{
		$this->assertSame($this->entity,$this->entity->setName($in));
	}
	
	/**
	 * @test
	 * @depends testSetName
	 * @dataProvider providerName
	 */
	public function testGetName($in, $out)
	{
		$this->entity->setName($in);
		$this->assertSame($out,$this->entity->getName());
	}
	
	public function providerZip()
	{
		return array(
				array('77280','77280'),
				array('2B280','2B280'),
				array('2a280','2A280'),
				array('dCg-Pt3','DCG-PT3'),
				array(52364,'52364'),
				array('?',''),
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerZip
	 */
	public function testSetZip($in, $out)
	{
		$this->assertSame($this->entity,$this->entity->setZip($in));
	}
	
	/**
	 * @test
	 * @dataProvider providerZip
	 * @depends testSetZip
	 */
	public function testGetZip($in, $out)
	{
		$this->entity->setZip($in);
		$this->assertSame($out,$this->entity->getZip());
	}
	
	/**
	 * @test
	 */
	public function testSetCountry()
	{
		$this->assertSame($this->entity,$this->entity->setCountry($this->country));
	}
	
	/**
	 * @test
	 * @depends testSetCountry
	 */
	public function testGetCountry()
	{
		$this->entity->setCountry($this->country);
		$this->assertEquals($this->country,$this->entity->getCountry());
	}
	
	public function provider__toString()
	{
		return array(
			array('','',''),
			array('Othis','','Othis'),
			array('','77280','77280'),
			array('Othis','77280','77280 - Othis'),
			
		);
	}
	
	/**
	 * @test
	 * @dataProvider provider__toString
	 * @depends testSetName
	 * @depends testSetZip
	 */
	public function test__toString($city,$zip,$out)
	{
		$this->entity->setName($city);
		$this->entity->setZip($zip);
		$this->assertSame($out,$this->entity->__toString());
	}
	
	public function providerToString()
	{
		return array(
				array('','',''),
				array('Othis','','OTHIS'),
				array('','77280','77280'),
				array('Othis','77280','77280 - OTHIS'),
					
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerToString
	 * @depends testSetName
	 * @depends testSetZip
	 */
	public function testToString($city, $zip, $out)
	{
		$this->entity->setName($city);
		$this->entity->setZip($zip);
		$this->assertSame($out,$this->entity->toString());
	}

}