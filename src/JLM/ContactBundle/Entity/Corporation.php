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
     * @var integer $id
     * @deprecated
     */
    private $id;
    
    /**
     * @var string
     */
    private $name = '';
	
	/**
	 * @var PersonInterface[] $contacts
	 *
     */
	private $contacts;

	/**
	 * @var string $phone
	 */
	private $phone;
	
	/**
	 * Get id
	 * @deprecated
	 * @return integer
	 */
	public function getId()
	{
	    return $this->id;
	}
	
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
     * Add contacts
     *
     * @param CorporationContactInterface $contacts
     * @return bool
     */
    public function addContact(CorporationContactInterface $contacts)
    {
    	$this->contacts->add($contacts);
    	
    	return true;
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
}