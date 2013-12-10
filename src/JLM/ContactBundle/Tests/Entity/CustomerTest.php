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
		$this->entity = new Customer;
		$this->contact = $this->getMockForAbstractClass('JLM\ContactBundle\Entity\Contact');
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertNull($this->entity->getId());
	}
	
	/**
	 * @test
	 */
	public function testSetContact()
	{
		$this->assertSame($this->entity, $this->entity->setContact($this->contact));
	}
	
	/**
	 * @test
	 * @expectedException \Exception
	 */
	public function testSetContactException()
	{
		$this->entity->setContact('foo');
	}
	
	/**
	 * @test
	 * @depends testSetContact
	 */
	public function testGetContact()
	{
		$this->entity->setContact($this->contact);
		$this->assertSame($this->contact,$this->entity->getContact());
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
}
