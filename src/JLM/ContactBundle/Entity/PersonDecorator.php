<?php
namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Model\PersonInterface;
use JLM\ContactBundle\Model\ContactAddressInterface;
use JLM\ContactBundle\Model\ContactEmailInterface;
use JLM\ContactBundle\Model\ContactPhoneInterface;

/**
 * @ORM\MappedSuperclass
 */
abstract class PersonDecorator extends ContactDecorator implements PersonInterface
{	
	/**
	 * Constructor
	 * @param ContactInterface $contact
	 */
	public function __construct(PersonInterface $person)
	{
		parent::__construct($contact);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getFirstName()
	{
		return $this->person->getFirstName();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getLastName()
	{
		return $this->person->getLastName();
	}
}