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
use JLM\ContactBundle\Model\ContactInterface;
use JLM\ContactBundle\Model\AddressInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class Contact implements ContactInterface
{
    /**
     * @var int
     * Ehancement
     */
//    protected $id;
    
    /**
     * @var string
     * Ehancement
     */
//    protected $name = '';
    
	/**
	 * @var Address $address
	 */
	protected $address;
	
	/**
	 * @var string $fax
	 */
	protected $fax;
	
	/**
	 * @var email $email
	 */
	protected $email;
	
	/**
	 * Get id
	 * @return int
	 * Ehancement
	 */
//	public function getId()
//	{
//	    return $this->id;
//	}
	
	/**
	 * Set text
	 *
	 * @param string $text
	 * Ehancement
	 */
//	public function setName($name)
//	{
//	    $this->name = $name;
//	    return $this;
//	}
	
	/**
	 * Get text
	 *
	 * @return string
	 * Ehancement
	 */
//	public function getName()
//	{
//	    return $this->name;
//	}
	
	abstract public function getName();
	
	/**
	 * To String
	 * @return string
	 */
	public function __toString()
	{
	    return $this->getName();
	}

	/**
	 * Set fax
	 *
	 * @param string $fax
	 * @return self
	 */
	public function setFax($fax)
	{
	    $this->fax = $fax;
	
	    return $this;
	}
	
	/**
	 * Get fax
	 *
	 * @return string
	 */
	public function getFax()
	{
	    return $this->fax;
	}
	
    /**
     * Set email
     *
     * @param string $email
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param AddressInterface $address
     * @return self
     */
    public function setAddress(AddressInterface $address = null)
    {
        $this->address = $address;
        
        return $this;
    }

    /**
     * Get address
     *
     * @return AddressInterface
     */
    public function getAddress()
    {
        return $this->address;
    }
}