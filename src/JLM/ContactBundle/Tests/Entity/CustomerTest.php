<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\Customer;
use JLM\ContactBundle\Entity\Contact;

class CustomerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->address = $this->getMock('JLM\ContactBundle\Model\AddressInterface');
		
		
		$this->contact = $this->getMockForAbstractClass('JLM\ContactBundle\Model\ContactInterface');
		$this->contact->expects($this->any())->method('getName')->will($this->returnValue('M. Emmanuel Bernaszuk'));
		$this->contact->expects($this->any())->method('getMainAddress')->will($this->returnValue($this->address));
		$this->entity = new Customer($this->contact);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertNull($this->entity->getId());
		$this->assertSame('M. Emmanuel Bernaszuk',$this->entity->getName());
		$this->assertSame('M. Emmanuel Bernaszuk',$this->entity->getBillingName());
		$this->assertSame((string)$this->address,$this->entity->getBillingAddress());
	}
	
	public function providerAccountNumber()
	{
		return array(
				array(411000,411000),
				array('411000',411000),
				array('00520',520),
				array('',null),
		);
	}

	public function providerAccountNumberException()
	{
		return array(
			array('foo'),	// décimal
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerAccountNumber
	 */
	public function testSetAccountNumber($in)
	{
		$this->assertSame($this->entity, $this->entity->setAccountNumber($in));
	}
	
	/**
	 * @test
	 * @dataProvider providerAccountNumberException
	 * @expectedException JLM\ContactBundle\Entity\CustomerException
	 */
	public function testSetAccountNumberException($in)
	{
		$this->entity->setAccountNumber($in);
	}
	
	/**
	 * @test
	 * @dataProvider providerAccountNumber
	 * @depends testSetAccountNumber
	 */
	public function testGetAccountNumber($in,$out)
	{
		$this->entity->setAccountNumber($in);
		$this->assertSame($out,$this->entity->getAccountNumber());
	}
	
	/**
	 * @test
	 */
	public function testGetName()
	{
		$this->assertSame('M. Emmanuel Bernaszuk',$this->entity->getName());
	}
	
	/**
	 * @test
	 */
	public function testSetBillingName()
	{
		$this->assertSame($this->entity, $this->entity->setBillingName('Manu'));
	}
	
	/**
	 * @test
	 */
	public function testGetBillingName()
	{
		$this->entity->setBillingName('Manu');
		$this->assertSame('Manu',$this->entity->getBillingName());
	}
	
	/**
	 * @test
	 */
	public function testRemoveBillingName()
	{
		$this->entity->setBillingName('Manu');
		$this->entity->setBillingName();
		$this->assertSame('M. Emmanuel Bernaszuk',$this->entity->getBillingName());
	}
	
	/**
	 * @test
	 */
	public function testSetBillingAddress()
	{
		$this->assertSame($this->entity, $this->entity->setBillingAddress($this->getMock('JLM\ContactBundle\Model\AddressInterface')));
	}
	
	/**
	 * @test
	 */
	public function testGetBillingAddress()
	{
		$address = $this->getMock('JLM\ContactBundle\Model\AddressInterface');
		$this->entity->setBillingAddress($address);
		$this->assertSame((string)$address, $this->entity->getBillingAddress());
	}
}
