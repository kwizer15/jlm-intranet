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
	
	public function testName()
	{
		$entity = new City;
		$this->assertEquals('',$entity->getName());
		$this->assertInternalType('string',$entity->getName());
	
		$tests = array('paris'=>'Paris','MONTPELLIER'=>'Montpellier','bouLOgNe-biLLancOuRt'=>'Boulogne-Billancourt','Paris 13 Buttes-Chaumonts'=>'Paris 13 Buttes-Chaumonts');
		foreach ($tests as $in => $out)
		{
			$this->assertEquals($entity,$entity->setName($in));
			$this->assertEquals($out,$entity->getName());
			$this->assertInternalType('string',$entity->getName());
		}
	}
	
	/**
	 * @test
	 */
	public function testZip()
	{
		$entity = new City;
		$this->assertInternalType('string',$entity->getZip());
		$this->assertEquals('',$entity->getZip());
		
		$tests = array('77280'=>'77280','2B280'=>'2B280', '2a280'=>'2A280', 'dCg-Pt3'=>'DCG-PT3', 52364 => '52364','?'=>'');
		
		foreach ($tests as $in => $out)
		{
			$this->assertEquals($entity,$entity->setZip($in));
			$this->assertEquals($out,$entity->getZip());
			$this->assertInternalType('string',$entity->getZip());
		}
	}
	
	/**
	 * @test
	 */
	public function testCountry()
	{
		$entity = new City;
		$country = new Country;
		$this->assertNull($entity->getCountry());
		
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