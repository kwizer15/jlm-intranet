<?php

/*
 * This file is part of the JLMCondominiumBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CondominiumBundle\Entity;

use JLM\CondominiumBundle\Model\ManagerInterface;
use JLM\CondominiumBundle\Model\AdministratorManagerInterface;
use JLM\ContactBundle\Entity\Company;
use JLM\ContactBundle\Entity\ContactDecorator;
use JLM\ContactBundle\Entity\CorporationContact;
use JLM\ContactBundle\Model\CorporationContactInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class AdministratorManager implements AdministratorManagerInterface
{
	private $manager;
	
	private $administrator;
	
	private $contacts;
	
	/**
	 * Set the manager
	 *
	 * @param string $manager
	 * @return self
	 */
	public function setManager(ManagerInterface $manager)
	{
		$this->manager = $manager;
		
		return $this;
	}
	
	/**
	 * Get the manager
	 *
	 * @return ManagerInterface
	 */
	public function getManager()
	{
		return $this->manager;
	}
	
	/**
	 * Set the administrator
	 *
	 * @param string $administrator
	 * @return self
	 */
	public function setAdministrator($administrator)
	{
		$this->administrator = $administrator;
		
		return $this;
	}
	
	/**
	 * Get the administrator
	 *
	 * @return string
	 */
	public function getAdministrator()
	{
		return $this->administrator;
	}
	
	/**
	 * Set the contacts
	 *
	 * @param string $contacts
	 * @return self
	 */
	public function addContact(CorporationContactInterface $contact)
	{
		if ($contact->getCorporation() == $this->getManager())
		$this->contacts->add($contacts);
		
		return $this;
	}
	
	/**
	 * Get the contacts
	 *
	 * @return string
	 */
	public function getContacts()
	{
		return $this->contacts;
	}
	
	
}