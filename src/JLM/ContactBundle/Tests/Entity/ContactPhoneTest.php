<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\ContactPhone;
use JLM\ContactBundle\Entity\Phone;

class ContactPhoneTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->entity = new ContactPhone();
		$this->phone = $this->getMock('JLM\ContactBundle\Model\PhoneInterface');
		$this->phone->expects($this->any())->method('__toString')->will($this->returnValue('01 64 33 77 70'));
		$this->entity->setPhone($this->phone);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertSame($this->phone,$this->entity->getPhone());
	}
	
	/**
	 * @test
	 */
	public function test__toString()
	{
		$this->assertSame($this->phone->__toString(), $this->entity->__toString());
	}
}