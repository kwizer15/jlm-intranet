<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\Address;
use JLM\ContactBundle\Entity\City;

class AddressTest extends \PHPUnit_Framework_TestCase
{
	protected $entity;
	
	public function setUp()
	{
		$this->entity = new Address;
	}
	
	/**
	 * @test
	 */
	public function testInitialGetId()
	{
		$this->assertNull($this->entity->getId());
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
	public function testSetStreet($in,$out)
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
		$this->assertEquals($out,$this->entity->getStreet());
	}
	
	public function providerCity()
	{
		return array(
			array(new City,false),
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerCity
	 */
	public function testSetCity($data,$exception)
	{
		try {
			$this->assertSame($this->entity,$this->entity->setCity($data));
			if ($exception)
				$this->fail('Eception non levée');
		} catch (\Exception $e) {
			if (!$exception)
			$this->fail('Exception levée : '.$e);
		}
	}
	
	/**
	 * @test
	 * @dataProvider providerCity
	 * @depends testSetCity
	 */
	public function testGetCity($data,$exception)
	{
		if (!$exception)
		{
			$this->entity->setCity($data);
			$this->assertSame($data,$this->entity->getCity());
		}
	}
	
	public function providerCityName()
	{
		return array(
				array('Othis', 'Othis'),
				array('Paris 15', 'Paris 15'),
				array('Boulogne-billancourt', 'Boulogne-Billancourt'),
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerCityName
	 */
	public function testSetCityName($in,$out)
	{
		$this->assertSame($this->entity,$this->entity->setCityName($in));
	}
	
	/**
	 * @test
	 * @dataProvider providerCityName
	 * @depends testSetCityName
	 */
	public function testGetCityName($in,$out)
	{
		$this->entity->setCityName($in);
		$this->assertSame($out,$this->entity->getCityName());
		
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
	public function testSetZip($in)
	{
		$this->assertSame($this->entity,$this->entity->setZip($in));
	}
	
	/**
	 * @test
	 * @dataProvider providerZip
	 * @depends testSetZip
	 */
	public function testGetZip($in)
	{
		$this->entity->setZip($in);
		$this->assertSame($this->entity->getCity()->getZip(),$this->entity->getZip());
	}
	
	public function provider__toString()
	{
		return array(
				array(
						'1, boulevard Michelet',
						'77280',
						'Othis',
						'1, boulevard Michelet'.chr(10).'77280 - Othis'
				),
				array(
						'33, rue Saint-Exupéry',
						'75001',
						'Paris',
						'33, rue Saint-Exupéry'.chr(10).'75001 - Paris'
				),
		);
	}
	
	/**
	 * @test
	 * @dataProvider provider__toString
	 * @depends testSetStreet
	 * @depends testSetCity
	 */
	public function test__toString($street,$zip,$cityName,$out)
	{	
		$city = new City;
		$city->setName($cityName)->setZip($zip);
		$this->entity->setStreet($street);
		$this->entity->setCity($city);
		$this->assertSame($out,$this->entity->__toString());
	}

}