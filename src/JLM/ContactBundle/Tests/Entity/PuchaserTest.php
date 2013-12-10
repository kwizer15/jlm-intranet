<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\Purchaser;

class PurchaserTest extends \PHPUnit_Framework_TestCase
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
		$this->entity = new Purchaser($this->contact);
	}

	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertNull($this->entity->getId());
		$this->assertSame('M. Emmanuel Bernaszuk',$this->entity->getName());
	}

	/**
	 * @test
	 */
	public function testGetName()
	{
		$this->assertSame('M. Emmanuel Bernaszuk',$this->entity->getName());
	}
}
