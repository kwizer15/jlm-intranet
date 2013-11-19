<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Entity\EmailException;

/**
 * Email
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Email
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;
    
    /**
     * @var Contact
     *
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="emails")
     */
    private $contact = null;

    

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
    	return $this->id;
    }
    
    public function setAddress($address)
    {
    	$address = strtolower(trim($address));
    	if (!filter_var($address, FILTER_VALIDATE_EMAIL))
    		throw new EmailException('e-mail address invalid');
    	$this->address = $address;
    	return $this;
    }
    
    public function getAddress()
    {
    	return $this->address;
    }
    
    /**
     * Set contact
     *
     * @param \JLM\ContactBundle\Entity\Contact $contact
     * @return ContactAddress
     */
    public function setContact(\JLM\ContactBundle\Entity\Contact $contact = null)
    {
    	$this->contact = $contact;
    
    	return $this;
    }
    
    /**
     * Get contact
     *
     * @return \JLM\ContactBundle\Entity\Contact
     */
    public function getContact()
    {
    	return $this->contact;
    }
    
    /**
     * Get address
     *
     * @return string 
     */
    public function __toString()
    {
        return $this->address;
    }
}
