<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JLM\ContactBundle\Model\CorporationInterface;
use JLM\ContactBundle\Model\CorporationContactInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class Corporation extends Contact implements CorporationInterface
{ 
	/**
	 * @var CorporationContactInterface[] $contacts
	 *
     */
	private $contacts;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
	    parent::__construct();
		$this->contacts = new ArrayCollection;
	}

    /**
     * Add contacts
     *
     * @param CorporationContactInterface $contact
     * @return bool
     */
    public function addContact(CorporationContactInterface $contact)
    {
    	return $this->contacts->add($contact);
    }
    
    /**
     * Remove contacts
     *
     * @param CorporationContactInterface $contact
     * @return bool
     */
    public function removeContact(CorporationContactInterface $contact)
    {
        return $this->contacts->removeElement($contact);
    }
    
    /**
     * Get contacts
     *
     * @return CorporationContactInterface[]
     */
    public function getContacts()
    {
    	return $this->contacts;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhone()
    {
        return $this->_getPhoneNumber('Principal');
    }
}