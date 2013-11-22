<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\ContactAddress;

class ContactAddressTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function testInitialId()
	{
		$entity = new ContactAddress;
		$this->assertNull($entity->getId());
	}
	
	
	public function booleans()
	{
		return array(
			array(false,false),
			array(true,true),
			array(null,false),
			array(1,true),
			array(0,false),
			array('1',true),
			array('0',false),
			array('foo',true),
		);
	}
	
	/**
	 * @test
	 */
	public function testInitialForBilling()
	{
		$entity = new ContactAddress;
		$this->assertSame(false,$entity->getForBilling());
	}
	
	/**
	 * @test
	 */
	public function testInitialForDelivery()
	{
		$entity = new ContactAddress;
		$this->assertSame(false,$entity->getForDelivery());
	}
	
	/**
	 * @test
	 */
	public function testInitialMain()
	{
		$entity = new ContactAddress;
		$this->assertSame(false,$entity->getMain());
	}
	
	/**
	 * @test
	 * @dataProvider booleans
	 */
	public function testForBilling($in,$out)
	{
		$entity = new ContactAddress;
		
		$this->assertEquals($entity,$entity->setForBilling($in));
		$this->assertSame($out,$entity->getForBilling());
		$this->assertSame($out,$entity->isForBilling());
	}
	
	/**
	 * @test
	 * @dataProvider booleans
	 */
	public function testForDelivery($in,$out)
	{
		$entity = new ContactAddress;
	
		$this->assertEquals($entity,$entity->setForDelivery($in));
		$this->assertSame($out,$entity->getForDelivery());
		$this->assertSame($out,$entity->isForDelivery());
	
	}
	
	/**
	 * @test
	 * @dataProvider booleans
	 */
	public function testMain($in,$out)
	{
		$entity = new ContactAddress;
	
		$this->assertEquals($entity,$entity->setMain($in));
		$this->assertSame($out,$entity->getMain());
		$this->assertSame($out,$entity->isMain());
	}
}