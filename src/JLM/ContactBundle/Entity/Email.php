<?php

namespace JLM\ContactBundle\Entity;

use JLM\ContactBundle\Model\EmailInterface;

class EmailException extends \Exception {}

/**
 * Email
 */
class Email implements EmailInterface
{
	/**
	 * @var integer $id
	 */
	private $id;
	
    /**
     * @var string
     */
    private $address;
    
    /**
     * {@inheritdoc}
     */
    public function __construct($address = null)
    {
    	$this->setAddress($address);
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
     * Set address
     * @param string $address
     * @throws EmailException
     * @return self
     */
    public function setAddress($address)
    {
    	if ($address !== null)
    	{
    		$address = strtolower(trim($address));
    		if (!filter_var($address, FILTER_VALIDATE_EMAIL))
    			throw new EmailException('e-mail address invalid');
    	}
    	
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
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getAddress();
    }
}
