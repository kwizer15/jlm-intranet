<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Entity\Contact;

/**
 * ContactAddress
 *
 * @ORM\Table(name="contact_addresses")
 * @ORM\Entity
 */
class ContactAddress extends ContactData
{
	/**
	 * @var Address
	 * 
	 * @ORM\ManyToOne(targetEntity="Address")
	 */
	private $address = null;
    
    /**
     * @var forBilling
     * 
     * @ORM\Column(name="for_billing", type="boolean")
     */
    private $forBilling = false;
    
    /**
     * @var forDelivery
     *
     * @ORM\Column(name="for_delivery", type="boolean")
     */
    private $forDelivery = false;
    
    /**
     * @var main
     *
     * @ORM\Column(name="main", type="boolean")
     */
    private $main = false;

    /**
     * Set forBilling
     *
     * @param boolean $forBilling
     * @return self
     */
    public function setForBilling($forBilling = true)
    {
        $this->forBilling = (bool)$forBilling;
    
        return $this;
    }

    /**
     * Get forBilling
     *
     * @return boolean 
     */
    public function getForBilling()
    {
        return $this->forBilling;
    }
    
    /**
     * Is forBilling
     *
     * @return boolean
     */
    public function isForBilling()
    {
    	return $this->getForBilling();
    }

    /**
     * Set forDelivery
     *
     * @param boolean $forDelivery
     * @return self
     */
    public function setForDelivery($forDelivery = true)
    {
        $this->forDelivery = (bool)$forDelivery;
    
        return $this;
    }

    /**
     * Get forDelivery
     *
     * @return boolean 
     */
    public function getForDelivery()
    {
        return $this->forDelivery;
    }
    
    /**
     * is forDelivery
     *
     * @return boolean
     */
    public function isForDelivery()
    {
    	return $this->getForDelivery();
    }

    /**
     * Set main
     *
     * @param boolean $main
     * @return self
     */
    public function setMain($main = true)
    {
        $this->main = (bool)$main;
    
        return $this;
    }

    /**
     * Get main
     *
     * @return boolean 
     */
    public function getMain()
    {
        return $this->main;
    }
    
    /**
     * Is main
     *
     * @return boolean
     */
    public function isMain()
    {
    	return $this->getMain();
    }
    
    /**
     * To string
     * 
     * @return string
     */
    public function __toString()
    {
    	return (string)$this->getAddress();
    }
}