<?php
namespace JLM\ContactBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use JLM\ContactBundle\Entity\ContactAddress;
use JLM\ContactBundle\Entity\ContactPhone;
use JLM\ContactBundle\Entity\ContactEmail;

class ContactDecoratorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->contact = $this->getMock('JLM\ContactBundle\Model\ContactInterface');
		$this->contact->expects($this->any())->method('getName')->will($this->returnValue('JLM Entreprise'));
		$this->entity = $this->getMockForAbstractClass('JLM\ContactBundle\Entity\ContactDecorator', array($this->contact));
		
		
		$this->address = $this->getMock('JLM\ContactBundle\Model\ContactAddressInterface');
		$this->phone = $this->getMock('JLM\ContactBundle\Model\ContactPhoneInterface');
		$this->email = $this->getMock('JLM\ContactBundle\Model\ContactEmailInterface');
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertSame('JLM Entreprise',$this->entity->getName());
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
		$this->contact->expects($this->once())->method('addAddress');
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
		$this->contact->expects($this->once())->method('getAddresses');
		$this->entity->getAddresses();
		return $this->entity;
	}

	/**
	 * @test
	 * @depends testAddAddress
	 */
	public function testRemoveAddress()
	{
		$this->contact->expects($this->once())->method('removeAddress');
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
	public function testGetMainAddress()
	{
		$this->contact->expects($this->once())->method('getMainAddress');
		$this->entity->getMainAddress();
	}
	
	
	/**
	 * @test
	 */
	public function testAddPhone()
	{
		$this->contact->expects($this->once())->method('addPhone');
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
		$this->contact->expects($this->once())->method('getPhones');
		$this->entity->getPhones();
		return $this->entity;
	}
	
	/**
	 * @test
	 * @depends testAddPhone
	 */
	public function testRemovePhone()
	{
		$this->contact->expects($this->once())->method('removePhone');
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
		$this->contact->expects($this->once())->method('addEmail');
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
		$this->contact->expects($this->once())->method('getEmails');
		$this->entity->getEmails();
		return $this->entity;
	}
	
	/**
	 * @test
	 * @depends testAddEmail
	 */
	public function testRemoveEmail()
	{
		$this->contact->expects($this->once())->method('removeEmail');
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