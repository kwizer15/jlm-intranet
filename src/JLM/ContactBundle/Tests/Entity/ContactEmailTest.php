<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\ContactEmail;

class ContactEmailTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->email = $this->getMock('JLM\ContactBundle\Model\EmailInterface');
		$this->email->expects($this->any())->method('__toString')->will($this->returnValue('emmanuel.bernaszuk@jlm-entreprise.fr'));
		
		$this->contact = $this->getMock('JLM\ContactBundle\Model\ContactInterface');
		$this->contact->expects($this->any())
		->method('getName')
		->will($this->returnValue('JLM Entreprise'));
		
		$this->entity = new ContactEmail($this->contact,'Bureau',$this->email);
		$this->entity->setEmail($this->email);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertNull($this->entity->getId());
		$this->assertSame($this->contact,$this->entity->getContact());
		$this->assertSame('Bureau',$this->entity->getAlias());
		$this->assertSame($this->email,$this->entity->getEmail());
	}
	
	/**
	 * @test
	 */
	public function test__toString()
	{
		$this->assertSame($this->email->__toString(), $this->entity->__toString());
	}
}