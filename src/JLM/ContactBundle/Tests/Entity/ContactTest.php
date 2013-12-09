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
		$this->address = $this->getMock('JLM\ContactBundle\Entity\ContactAddressInterface');
		$this->phone = $this->getMock('JLM\ContactBundle\Entity\ContactPhoneInterface');
		$this->email = $this->getMock('JLM\ContactBundle\Entity\ContactEmailInterface');
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
		$this->assertSame($this->entity, $this->entity->addAddress($this->address));
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
		$this->entity->addAddress($this->getMock('JLM\ContactBundle\Entity\ContactAddressInterface'));
		$this->entity->addAddress($this->getMock('JLM\ContactBundle\Entity\ContactAddressInterface'));
		$this->entity->addAddress($this->getMock('JLM\ContactBundle\Entity\ContactAddressInterface'));
		$this->assertCount(3, $this->entity->getAddresses());
		return $this->entity;
	}

	/**
	 * @test
	 * @depends testAddAddress
	 */
	public function testRemoveAddress()
	{
		$this->assertSame($this->entity, $this->entity->removeAddress($this->address));
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
		$this->assertSame($this->entity, $this->entity->addPhone($this->phone));
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
		$this->entity->addPhone($this->getMock('JLM\ContactBundle\Entity\ContactPhoneInterface'));
		$this->entity->addPhone($this->getMock('JLM\ContactBundle\Entity\ContactPhoneInterface'));
		$this->entity->addPhone($this->getMock('JLM\ContactBundle\Entity\ContactPhoneInterface'));
		$this->assertCount(3, $this->entity->getPhones());
		return $this->entity;
	}
	
	/**
	 * @test
	 * @depends testAddPhone
	 */
	public function testRemovePhone()
	{
		$this->assertSame($this->entity, $this->entity->removePhone($this->phone));
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
		$this->assertSame($this->entity, $this->entity->addEmail($this->email));
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
		$this->entity->addEmail($this->email);
		$this->entity->addEmail($this->email);
		$this->entity->addEmail($this->email);
		$this->assertCount(3, $this->entity->getEmails());
		return $this->entity;
	}
	
	/**
	 * @test
	 * @depends testAddEmail
	 */
	public function testRemoveEmail()
	{
		$this->assertSame($this->entity, $this->entity->removeEmail($this->email));
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