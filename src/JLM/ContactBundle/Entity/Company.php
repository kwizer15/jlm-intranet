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
use JLM\ContactBundle\Model\CompanyInterface;
use JLM\ContactBundle\Model\AddressInterface;
use JLM\ContactBundle\Model\PersonInterface;


/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Company extends Contact implements CompanyInterface
{
	/**
     * @var integer $id
     */
    private $id;
	
    /**
     * @var string
     */
    private $name = '';
	
	/**
	 * @var Person[] $contacts
	 *
     */
	private $contacts;

	/**
	 * @var string $phone
	 */
	private $phone;
	
	/**
	 * @var string $fax
	 */
	private $fax;
	
	/**
	 * Set phone
	 *
	 * @param string $phone
	 * @return self
	 */
	public function setPhone($phone)
	{
	    $this->phone = $phone;
	
	    return $this;
	}
	
	/**
	 * Get phone
	 *
	 * @return string
	 */
	public function getPhone()
	{
	    return $this->phone;
	}

	/**
	 * Set text
	 *
	 * @param string $text
	 */
	public function setName($name)
	{
	    $this->name = $name;
	    return $this;
	}
	
	/**
	 * Get text
	 *
	 * @return string
	 */
	public function getName()
	{
	    return $this->name;
	}
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->contacts = new ArrayCollection;
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add contacts
     *
     * @param PersonInterface $contacts
     * @return bool
     */
    public function addContact(PersonInterface $contacts)
    {
    	$this->contacts[] = $contacts;
    	
    	return true;
    }
    
    /**
     * Get contacts
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
    	return $this->contacts;
    }
}