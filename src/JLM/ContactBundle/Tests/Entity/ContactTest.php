<?php
namespace JLM\ContactBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use JLM\ContactBundle\Entity\ContactAddress;
use JLM\ContactBundle\Entity\ContactPhone;
use JLM\ContactBundle\Entity\ContactEmail;

class ContactTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->entity = $this->getMockForAbstractClass('JLM\ContactBundle\Entity\Contact');
	}
	
	/**
	 * @test
	 */
	public function testId()
	{
		$this->assertNull($this->entity->getId());
	}
	
	/**
	 * @test
	 */
	public function testAddAddress()
	{
		$this->assertSame($this->entity, $this->entity->addAddress(new ContactAddress));
	}
	
	/**
	 * @test
	 */
	public function testAddBillingAddress()
	{
		$this->assertSame($this->entity, $this->entity->addBillingAddress(new ContactAddress));
	}
	
	/**
	 * @test
	 * @depends testAddBillingAddress
	 */
	public function testGetBillingAddress()
	{
		$data = new ContactAddress;
		$this->entity->addBillingAddress($data);
		$this->assertSame($data, $this->entity->getBillingAddress());
	}
	
	/**
	 * @test
	 * @depends testGetBillingAddress
	 */
	public function testNoBillingAddress()
	{
		$this->assertNull($this->entity->getBillingAddress());
	}
	

	/**
	 * @test
	 * @depends testAddAddress
	 * @expectedException \Exception
	 */
	public function testAddAddressException()
	{
		$this->entity->addAddress('foo');
	}
	
	/**
	 * @test
	 * @depends testAddAddress
	 */
	public function testGetAddresses()
	{
		$this->entity->addAddress(new ContactAddress);
		$this->entity->addAddress(new ContactAddress);
		$this->entity->addAddress(new ContactAddress);
		$this->assertCount(3, $this->entity->getAddresses());
		return $this->entity;
	}

	/**
	 * @test
	 * @depends testAddAddress
	 */
	public function testRemoveAddress()
	{
		$this->entity->addAddress(new ContactAddress);
		$this->assertSame($this->entity, $this->entity->removeAddress(new ContactAddress));
	}
	
	/**
	 * @test
	 * @depends testAddAddress
	 * @expectedException \Exception
	 */
	public function testRemoveAddressException()
	{
		$this->entity->removeAddress('foo');
	}
	
	/**
	 * @test
	 */
	public function testAddPhone()
	{
		$this->assertSame($this->entity, $this->entity->addPhone(new ContactPhone));
	}
	
	/**
	 * @test
	 * @depends testAddPhone
	 * @expectedException \Exception
	 */
	public function testAddPhoneException()
	{
		$this->entity->addPhone('foo');
	}
	
	/**
	 * @test
	 * @depends testAddPhone
	 */
	public function testGetPhones()
	{
		$this->entity->addPhone(new ContactPhone);
		$this->entity->addPhone(new ContactPhone);
		$this->entity->addPhone(new ContactPhone);
		$this->assertCount(3, $this->entity->getPhones());
		return $this->entity;
	}
	
	/**
	 * @test
	 * @depends testAddPhone
	 */
	public function testRemovePhone()
	{
		$this->entity->addPhone(new ContactPhone);
		$this->assertSame($this->entity, $this->entity->removePhone(new ContactPhone));
	}
	
	/**
	 * @test
	 * @depends testAddPhone
	 * @expectedException \Exception
	 */
	public function testRemovePhoneException()
	{
		$this->entity->removePhone('foo');
	}
	
	/**
	 * @test
	 */
	public function testAddEmail()
	{
		$this->assertSame($this->entity, $this->entity->addEmail(new ContactEmail));
	}
	
	/**
	 * @test
	 * @depends testAddEmail
	 * @expectedException \Exception
	 */
	public function testAddEmailException()
	{
		$this->entity->addEmail('foo');
	}
	
	/**
	 * @test
	 * @depends testAddEmail
	 */
	public function testGetEmails()
	{
		$this->entity->addEmail(new ContactEmail);
		$this->entity->addEmail(new ContactEmail);
		$this->entity->addEmail(new ContactEmail);
		$this->assertCount(3, $this->entity->getEmails());
		return $this->entity;
	}
	
	/**
	 * @test
	 * @depends testAddEmail
	 */
	public function testRemoveEmail()
	{
		$this->entity->addEmail(new ContactEmail);
		$this->assertSame($this->entity, $this->entity->removeEmail(new ContactEmail));
	}
	
	/**
	 * @test
	 * @depends testAddPhone
	 * @expectedException \Exception
	 */
	public function testRemoveEmailException()
	{
		$this->entity->removeEmail('foo');
	}	
}