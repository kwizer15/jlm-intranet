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
class Email extends ContactData
{
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;
    
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
     * Get address
     *
     * @return string 
     */
    public function __toString()
    {
        return $this->address;
    }
}
