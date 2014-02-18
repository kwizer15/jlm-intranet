<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\CompanyPerson;

class CompanyPersonTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->role = 'Gestionnaire';
		$this->company = $this->getMock('JLM\ContactBundle\Model\CompanyInterface');
		$this->person = $this->getMock('JLM\ContactBundle\Model\PersonInterface');
		$this->entity = new CompanyPerson($this->person, $this->company, $this->role);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertInstanceOf('JLM\ContactBundle\Model\CompanyPersonInterface', $this->entity);
		$this->assertInstanceOf('JLM\ContactBundle\Entity\PersonDecorator', $this->entity);
	}
	
	/**
	 * @test
	 */
	public function testGetRole()
	{
		$this->assertSame($this->role, $this->entity->getRole());
	}
	
	/**
	 * @test
	 */
	public function testSetRole()
	{
		$this->assertSame($this->entity, $this->entity->setRole('Assistant'));
		$this->assertSame('Assistant', $this->entity->getRole());
	}
	
	/**
	 * @test
	 */
	public function testGetCompany()
	{
		$this->assertSame($this->company, $this->entity->getCompany());
	}
	
	/**
	 * @test
	 */
	public function testSetCompany()
	{
		$company = $this->getMock('JLM\ContactBundle\Model\CompanyInterface');
		$this->assertSame($this->entity, $this->entity->setCompany($company));
		$this->assertSame($company, $this->entity->getCompany());
	}
}