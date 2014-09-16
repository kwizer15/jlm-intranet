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

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JLM\ContactBundle\Model\CompanyInterface;
use JLM\ContactBundle\Model\AddressInterface;
use JLM\ContactBundle\Model\PersonInterface;


/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Company implements CompanyInterface
{
	/**
     * @var integer $id
     */
    private $id;
	
    /**
     * @var string
     *
     * @Assert\NotNull
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     */
    private $name = '';
    
	/**
	 * @var Address $address
	 * 
	 * @Assert\NotNull
	 * @Assert\Valid
	 */
	private $address;
	
	/**
	 * @var string $phone
	 * 
	 * @Assert\NotNull
	 * @Assert\Regex(pattern="/^0[1-9]\d{8}$/",message="Ce n'est pas un numéro de téléphone fixe valide")
	 */
	private $phone;
	
	/**
	 * @var string $fax
	 *
	 * @Assert\Regex(pattern="/^0[1-589]\d{8}$/",message="Ce n'est pas un numéro de fax valide")
	 */
	private $fax;
	
	/**
	 * @var email $email
	 *
	 * @Assert\Email
	 */
	private $email;
	
	
	/**
	 * @var Person[] $contacts
	 *
	 * @Assert\Valid(traverse="true")
	 */
	private $contacts;
	
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
	 * To String
	 */
	public function __toString()
	{
	    return $this->getName();
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
    public function setAddress(AddressInterface $address)
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