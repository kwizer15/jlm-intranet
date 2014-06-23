<?php
namespace JLM\ContactBundle\Entity;

use JLM\ContactBundle\Model\PersonInterface;

/**
 * PersonDecorator
 */
abstract class PersonDecorator extends ContactDecorator implements PersonInterface
{	
	/**
	 * Constructor
	 * @param PersonInterface $person
	 */
	public function __construct(PersonInterface $person)
	{
		parent::__construct($person);
	}
	
	/**
	 * @return PersonInterface
	 */
	public function getPerson()
	{
	    return $this->getContact();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getFirstName()
	{
		return $this->getPerson()->getFirstName();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getLastName()
	{
		return $this->getPerson()->getLastName();
	}
}