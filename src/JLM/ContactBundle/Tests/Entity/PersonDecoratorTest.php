<?php
namespace JLM\ContactBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class PersonDecoratorTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->person = $this->getMock('JLM\ContactBundle\Model\PersonInterface');
		$this->entity = $this->getMockForAbstractClass('JLM\ContactBundle\Entity\PersonDecorator', array($this->person));
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertInstanceOf('JLM\ContactBundle\Model\PersonInterface', $this->entity);
	}
	
	/**
	 * @test
	 */
	public function testGetFirstName()
	{
		$this->person->expects($this->once())->method('getFirstName');
		$this->entity->getFirstName();
	}
	
	/**
	 * @test
	 */
	public function testGetLastName()
	{
		$this->person->expects($this->once())->method('getLastName');
		$this->entity->getLastName();
	}
}