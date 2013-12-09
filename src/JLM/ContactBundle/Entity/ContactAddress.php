<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JLM\ContactBundle\Model\ContactDataInterface;
use JLM\ContactBundle\Model\AddressInterface;

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
	 * @ORM\ManyToOne(targetEntity="AddressInterface")
	 */
	private $address;
    
    /**
     * @var forBilling
     * 
     * @ORM\Column(name="for_billing", type="boolean")
     */
    // private $forBilling = false;
    // Pour Customer
    
    /**
     * @var forDelivery
     *
     * @ORM\Column(name="for_delivery", type="boolean")
     */
    // private $forDelivery = false;
    // Pour Customer
    
    /**
     * @var main
     *
     * @ORM\Column(name="main", type="boolean")
     */
    private $main = false;

    /**
     * @var label
     * 
     * @ORM\Column(name="label", type="string", nullable=true)
     */
    private $label;
    
    /**
     * Constructor
     */
    public function __construct(AddressInterface $address)
    {
    	$this->setAddress($address);
    }

    // Pour customer
//   /**
//    * Set forBilling
//    *
//    * @param boolean $forBilling
//    * @return self
//    */
//   public function setForBilling($forBilling = true)
//   {
//       $this->forBilling = (bool)$forBilling;
//   
//       return $this;
//   }
//
//   /**
//    * Get forBilling
//    *
//    * @return boolean 
//    */
//   public function getForBilling()
//   {
//       return $this->forBilling;
//   }
//   
//   /**
//    * Is forBilling
//    *
//    * @return boolean
//    */
//   public function isForBilling()
//   {
//   	return $this->getForBilling();
//   }
//
//   /**
//    * Set forDelivery
//    *
//    * @param boolean $forDelivery
//    * @return self
//    */
//   public function setForDelivery($forDelivery = true)
//   {
//       $this->forDelivery = (bool)$forDelivery;
//   
//       return $this;
//   }
//
//   /**
//    * Get forDelivery
//    *
//    * @return boolean 
//    */
//   public function getForDelivery()
//   {
//       return $this->forDelivery;
//   }
//   
//   /**
//    * is forDelivery
//    *
//    * @return boolean
//    */
//   public function isForDelivery()
//   {
//   	return $this->getForDelivery();
//   }

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
    	return $this->getAddress()->__toString();
    }
    
    /**
     * get Address
     * 
     * @return Address
     */
    public function getAddress()
    {
    	return $this->address;
    }
    
    /**
     * set Address
     * 
     * @param Address $address
     * @return self
     */
    public function setAddress(AddressInterface $address)
    {
    	$this->address = $address;
    	return $this;
    }

    /**
     * Set label
     *
     * @param string $label
     * @return ContactAddress
     */
    public function setLabel($label)
    {
    	if (empty($label))
    		$label = null;
        $this->label = $label;
    
        return $this;
    }

    /**
     * Get label
     *
     * @return string|null 
     */
    public function getLabel()
    {
        return $this->label;
    }
}