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
class ContactAddress extends Address
{
	/**
	 * @var Contact
	 * 
	 * @ORM\ManyToOne(targetEntity="Contact", inversedBy="addresses")
	 */
	private $contact = null;
	
    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=255)
     */
    private $alias = '';
    
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
     * Set alias
     *
     * @param string $alias
     * @return ContactAddress
     */
    public function setAlias($alias)
    {
    	$alias = ucfirst(strtolower(trim($alias)));
        $this->alias = $alias;
        return $this;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set forBilling
     *
     * @param boolean $forBilling
     * @return ContactAddress
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
     * Set forDelivery
     *
     * @param boolean $forDelivery
     * @return ContactAddress
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
     * Set main
     *
     * @param boolean $main
     * @return ContactAddress
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
}