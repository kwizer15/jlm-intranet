<?php
namespace JLM\ContactBundle\Entity;

use JLM\ContactBundle\Entity\PersonDecorator;
use JLM\ContactBundle\Model\CompanyInterface;
use JLM\ContactBundle\Model\PersonInterface;
use JLM\ContactBundle\Model\CompanyPersonInterface;

class CompanyPerson extends PersonDecorator implements CompanyPersonInterface
{
	/**
	 * The Company
	 * @var CompanyInterface
	 */
	private $company;
	
	/**
	 * Role in the company
	 * @var string
	 */
	private $role;
	
	/**
	 * Constructor
	 * 
	 * @param PersonInterface $person
	 * @param string $role 
	 */
	public function __construct(PersonInterface $person, CompanyInterface $company, $role)
	{
		parent::__construct($person);
		$this->setCompany($company);
		$this->setRole($role);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getRole()
	{
		return $this->role;
	}
	
	/**
	 * Set the role
	 * 
	 * @param string $role
	 * @return self
	 */
	public function setRole($role)
	{
		$this->role = $role;
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getCompany()
	{
		return $this->company;
	}
	
	/**
	 * Set the company
	 * 
	 * @param CompanyInterface $company
	 * @return self
	 */
	public function setCompany(CompanyInterface $company)
	{
		$this->company = $company;
		
		return $this;
	}
}