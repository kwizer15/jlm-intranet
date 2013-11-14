<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\Address;
use JLM\ContactBundle\Entity\City;

class AddressTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function testId()
	{
		$entity = new Address;
		$this->assertNull($entity->getId());
	}
	
	/**
	 * @test
	 */
	public function testStreet()
	{
		$entity = new Address;
		
		$this->assertEquals('',$entity->getStreet());
		
		// setter
		$this->assertEquals($entity,$entity->setStreet('1, rue Bidule Machin Truc'));
		
		// getter
		$this->assertEquals('1, rue Bidule Machin Truc',$entity->getStreet());
		$this->assertInternalType('string', $entity->getStreet());
		
		$this->assertEquals($entity,$entity->setStreet(153));
		$this->assertInternalType('string', $entity->getStreet());
		$this->assertEquals('153',$entity->getStreet());
		
	}
	
	/**
	 * @test
	 */
	public function testCity()
	{
		$entity = new Address;
		$city = new City;

		$this->assertNull($entity->getCity());
		$this->assertEquals($entity,$entity->setCity($city));
		$this->assertInstanceOf('JLM\ContactBundle\Entity\City',$entity->getCity());
	}
	
	/**
	 * @test
	 */
	public function test__toString()
	{
		$entity = new Address;
		$city = new City;
		
		$this->assertInternalType('string',$entity->__toString());
		$this->assertEquals('',$entity->__toString());
	
		$this->assertNull($entity->getCity());
		$this->assertEquals($entity,$entity->setCity($city));
		$this->assertInstanceOf('JLM\ContactBundle\Entity\City',$entity->getCity());
	}

}