<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\ContactAddress;

class ContactAddressTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function testId()
	{
		$entity = new ContactAddress;
		$this->assertNull($entity->getId());
	}
	
	/**
	 * @test
	 */
	public function testForBilling()
	{
		$entity = new ContactAddress;
		
		$this->assertEquals(false,$entity->getForBilling());
		$this->assertInternalType('bool', $entity->getForBilling());
	
		$this->assertEquals($entity,$entity->setForBilling(true));
		$this->assertEquals(true,$entity->getForBilling());
		$this->assertInternalType('bool', $entity->getForBilling());
		
		$this->assertEquals($entity,$entity->setForBilling(false));
		$this->assertEquals(false,$entity->getForBilling());
		$this->assertInternalType('bool', $entity->getForBilling());
		
		$this->assertEquals($entity,$entity->setForBilling(null));
		$this->assertEquals(false,$entity->getForBilling());
		$this->assertInternalType('bool', $entity->getForBilling());
		
		$this->assertEquals($entity,$entity->setForBilling(1));
		$this->assertEquals(true,$entity->getForBilling());
		$this->assertInternalType('bool', $entity->getForBilling());
		
		$this->assertEquals($entity,$entity->setForBilling(0));
		$this->assertEquals(false,$entity->getForBilling());
		$this->assertInternalType('bool', $entity->getForBilling());
		
		$this->assertEquals($entity,$entity->setForBilling('1'));
		$this->assertEquals(true,$entity->getForBilling());
		$this->assertInternalType('bool', $entity->getForBilling());
		
		$this->assertEquals($entity,$entity->setForBilling('0'));
		$this->assertEquals(false,$entity->getForBilling());
		$this->assertInternalType('bool', $entity->getForBilling());
		
		$this->assertEquals($entity,$entity->setForBilling('yes'));
		$this->assertEquals(true,$entity->getForBilling());
		$this->assertInternalType('bool', $entity->getForBilling());
		
		$this->assertEquals($entity,$entity->setForBilling('no'));
		$this->assertEquals(true,$entity->getForBilling());
		$this->assertInternalType('bool', $entity->getForBilling());

	}
	
	/**
	 * @test
	 */
	public function testForDelivery()
	{
		$entity = new ContactAddress;
	
		$this->assertEquals(false,$entity->getForDelivery());
		$this->assertInternalType('bool', $entity->getForDelivery());
	
		$this->assertEquals($entity,$entity->setForDelivery(true));
		$this->assertEquals(true,$entity->getForDelivery());
		$this->assertInternalType('bool', $entity->getForDelivery());
	
		$this->assertEquals($entity,$entity->setForDelivery(false));
		$this->assertEquals(false,$entity->getForDelivery());
		$this->assertInternalType('bool', $entity->getForDelivery());
	
		$this->assertEquals($entity,$entity->setForDelivery(null));
		$this->assertEquals(false,$entity->getForDelivery());
		$this->assertInternalType('bool', $entity->getForDelivery());
	
		$this->assertEquals($entity,$entity->setForDelivery(1));
		$this->assertEquals(true,$entity->getForDelivery());
		$this->assertInternalType('bool', $entity->getForDelivery());
	
		$this->assertEquals($entity,$entity->setForDelivery(0));
		$this->assertEquals(false,$entity->getForDelivery());
		$this->assertInternalType('bool', $entity->getForDelivery());
	
		$this->assertEquals($entity,$entity->setForDelivery('1'));
		$this->assertEquals(true,$entity->getForDelivery());
		$this->assertInternalType('bool', $entity->getForDelivery());
	
		$this->assertEquals($entity,$entity->setForDelivery('0'));
		$this->assertEquals(false,$entity->getForDelivery());
		$this->assertInternalType('bool', $entity->getForDelivery());
	
		$this->assertEquals($entity,$entity->setForDelivery('yes'));
		$this->assertEquals(true,$entity->getForDelivery());
		$this->assertInternalType('bool', $entity->getForDelivery());
	
		$this->assertEquals($entity,$entity->setForDelivery('no'));
		$this->assertEquals(true,$entity->getForDelivery());
		$this->assertInternalType('bool', $entity->getForDelivery());
	
	}
	
	/**
	 * @test
	 */
	public function testMain()
	{
		$entity = new ContactAddress;
	
		$this->assertEquals(false,$entity->getMain());
		$this->assertInternalType('bool', $entity->getMain());
	
		$this->assertEquals($entity,$entity->setMain(true));
		$this->assertEquals(true,$entity->getMain());
		$this->assertInternalType('bool', $entity->getMain());
	
		$this->assertEquals($entity,$entity->setMain(false));
		$this->assertEquals(false,$entity->getMain());
		$this->assertInternalType('bool', $entity->getMain());
	
		$this->assertEquals($entity,$entity->setMain(null));
		$this->assertEquals(false,$entity->getMain());
		$this->assertInternalType('bool', $entity->getMain());
	
		$this->assertEquals($entity,$entity->setMain(1));
		$this->assertEquals(true,$entity->getMain());
		$this->assertInternalType('bool', $entity->getMain());
	
		$this->assertEquals($entity,$entity->setMain(0));
		$this->assertEquals(false,$entity->getMain());
		$this->assertInternalType('bool', $entity->getMain());
	
		$this->assertEquals($entity,$entity->setMain('1'));
		$this->assertEquals(true,$entity->getMain());
		$this->assertInternalType('bool', $entity->getMain());
	
		$this->assertEquals($entity,$entity->setMain('0'));
		$this->assertEquals(false,$entity->getMain());
		$this->assertInternalType('bool', $entity->getMain());
	
		$this->assertEquals($entity,$entity->setMain('yes'));
		$this->assertEquals(true,$entity->getMain());
		$this->assertInternalType('bool', $entity->getMain());
	
		$this->assertEquals($entity,$entity->setMain('no'));
		$this->assertEquals(true,$entity->getMain());
		$this->assertInternalType('bool', $entity->getMain());
	
	}
}