<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Entity\EmailException;

class EmailException extends \Exception {}

/**
 * Email
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Email
{
    /**
     * @var string
     * 
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;
    
    /**
     * Set address
     * @param string $address
     * @throws EmailException
     * @return self
     */
    public function setAddress($address)
    {
    	$address = strtolower(trim($address));
    	if (!filter_var($address, FILTER_VALIDATE_EMAIL))
    		throw new EmailException('e-mail address invalid');
    	$this->address = $address;
    	return $this;
    }
    
    /**
     * Get address
     * 
     * @return string
     */
    public function getAddress()
    {
    	return $this->address;
    }
    
    /**
     * To string
     *
     * @return string 
     */
    public function __toString()
    {
        return $this->getAddress();
    }
}
