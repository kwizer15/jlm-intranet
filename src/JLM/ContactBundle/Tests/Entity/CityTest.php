<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\City;
use JLM\ContactBundle\Entity\Country;

class CityTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function testId()
	{
		$entity = new City;
		$this->assertNull($entity->getId());
	}
	
	/**
	 * @test
	 */
	public function testConstructWithoutParam()
	{
		$entity = new City;
		$this->assertSame('',$entity->getName());
		$this->assertSame('',$entity->getZip());
		$this->assertInstanceOf('JLM\ContactBundle\Entity\Country', $entity->getCountry());
		return $entity;
	}
	
	/**
	 * @test
	 */
	public function testConstructWithName()
	{
		$entity = new City('Othis');
		$this->assertSame('Othis',$entity->getName());
		$this->assertSame('',$entity->getZip());
	}
	
	/**
	 * @test
	 */
	public function testConstructWithZip()
	{
		$entity = new City('77280');
		$this->assertSame('',$entity->getName());
		$this->assertSame('77280',$entity->getZip());
	}
	
	/**
	 * @test
	 */
	public function testConstructWithNameAndZip()
	{
		$entity = new City('Othis','77280');
		$this->assertSame('Othis',$entity->getName());
		$this->assertSame('77280',$entity->getZip());
	}
	
	/**
	 * @test
	 */
	public function testConstructWithNameAndZipInversed()
	{
		$entity = new City('77280','Othis');
		$this->assertSame('Othis',$entity->getName());
		$this->assertSame('77280',$entity->getZip());
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
	 * @depends testConstructWithoutParam
	 * @dataProvider providerName
	 */
	public function testName($in, $out, City $entity)
	{
		$this->assertSame($entity,$entity->setName($in));
		$this->assertSame($out,$entity->getName());
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
	 * @depends testConstructWithoutParam
	 * @dataProvider providerZip
	 */
	public function testZip($in, $out, City $entity)
	{
		$this->assertSame($entity,$entity->setZip($in));
		$this->assertSame($out,$entity->getZip());
	}
	
	/**
	 * @test
	 */
	public function testCountry()
	{
		$entity = new City;
		$country = new Country;
		
		$this->assertEquals($entity,$entity->setCountry($country));
		$this->assertEquals($country,$entity->getCountry());
		$this->assertInstanceOf('JLM\ContactBundle\Entity\Country',$entity->getCountry());
		
		$this->assertEquals($entity,$entity->setCountry());
		$this->assertNull($entity->getCountry());
	}
	
	/**
	 * @test
	 */
	public function test__toString()
	{
		$entity = new City;
		$this->assertInternalType('string',$entity->__toString());
		$this->assertEquals('',$entity->__toString());
		$entity->setZip(77280)->setName('OTHIS');
		$this->assertInternalType('string',$entity->__toString());
		$this->assertEquals('77280 - Othis',$entity->__toString());
	}
	
	/**
	 * @test
	 */
	public function testtoString()
	{
		$entity = new City;
		$this->assertInternalType('string',$entity->toString());
		$this->assertEquals('',$entity->toString());
		$entity->setZip(77280)->setName('Othis');
		$this->assertInternalType('string',$entity->toString());
		$this->assertEquals('77280 - OTHIS',$entity->toString());
	}

}