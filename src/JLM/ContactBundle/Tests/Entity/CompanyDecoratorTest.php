<?php
namespace JLM\ContactBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class CompanyDecoratorTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->company = $this->getMock('JLM\ContactBundle\Model\CompanyInterface');
		$this->entity = $this->getMockForAbstractClass('JLM\ContactBundle\Entity\CompanyDecorator', array($this->company));
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertInstanceOf('JLM\ContactBundle\Model\CompanyInterface', $this->entity);
	}
	
	/**
	 * @test
	 */
	public function testGetName()
	{
		$this->company->expects($this->once())->method('getName');
		$this->entity->getName();
	}
	
	/**
	 * @test
	 */
	public function testSetName()
	{
		$this->company->expects($this->once())->method('setName');
		$this->entity->setName('Foo');
	}
	
	/**
	 * @test
	 */
	public function testGetSiret()
	{
		$this->company->expects($this->once())->method('getSiret');
		$this->entity->getSiret();
	}
	
	/**
	 * @test
	 */
	public function testSetSiret()
	{
		$this->company->expects($this->once())->method('setSiret');
		$this->entity->setSiret('52136548900052');
	}
	
	/**
	 * @test
	 */
	public function testGetSiren()
	{
		$this->company->expects($this->once())->method('getSiren');
		$this->entity->getSiren();
	}
	
	/**
	 * @test
	 */
	public function testSetSiren()
	{
		$this->company->expects($this->once())->method('setSiren');
		$this->entity->setSiren('521653845');
	}
	
	/**
	 * @test
	 */
	public function testGetNic()
	{
		$this->company->expects($this->once())->method('getNic');
		$this->entity->getNic();
	}
	
	/**
	 * @test
	 */
	public function testSetNic()
	{
		$this->company->expects($this->once())->method('setNic');
		$this->entity->setNic('00052');
	}
	
	/**
	 * @test
	 */
	public function testAddContact()
	{
		$this->company->expects($this->once())->method('addContact');
		$this->entity->addContact($this->getMock('JLM\ContactBundle\Model\CompanyPersonInterface'));
	}
	
	/**
	 * @test
	 */
	public function testRemoveContact()
	{
		$this->company->expects($this->once())->method('removeContact');
		$this->entity->removeContact($this->getMock('JLM\ContactBundle\Model\CompanyPersonInterface'));
	}
	
	/**
	 * @test
	 */
	public function testGetContacts()
	{
		$this->company->expects($this->once())->method('getContacts');
		$this->entity->getContacts();
	}
}