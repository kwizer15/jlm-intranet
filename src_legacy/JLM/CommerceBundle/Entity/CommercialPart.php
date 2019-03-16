<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Entity;

use JLM\CommerceBundle\Model\CommercialPartInterface;
use JLM\CommerceBundle\Model\CustomerInterface;
use JLM\CommerceBundle\Model\EventInterface;
use JLM\CommerceBundle\Model\EventFollowerInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class CommercialPart implements CommercialPartInterface
{
    /**
     * @var datetime $creation
     */
    private $creation;
    
    /**
     * Numéro du devis
     * @var int
     */
    private $number;
    
    /**
     * Client
     * @var CustomerInterface $trustee
     */
    private $trustee;

    /**
     * Copie du nom
     * @var string $trusteeName
     */
    private $trusteeName;
    
    /**
     * Copie de l'adresse de facturation
     * @var string $trusteeAddress
     */
    private $trusteeAddress;
    
    /**
     * @var float $vat
     */
    private $vat;
    
    /**
     * @var float $vatTransmitter
     */
    private $vatTransmitter;
    
    /**
     * Suivi d'évenements
     * @var EventFollowerInterface
     */
    private $eventFollower;
    
    public function __construct()
    {
        $this->setEventFollower(new EventFollower()); // @todo change to create
    }
    
    /**
     *
     * @param EventInterface $event
     * @return bool
     */
    public function addEvent($event, $options = [])
    {
        if (!$event instanceof Event) {
            $name = $event;
            $event = new Event(); // @todo change to create
            $event->setName($name);
            $event->setOptions($options);
        }
        
        return $this->getEventFollower()->addEvent($event);
    }
    
    /**
     *
     * @param EventInterface $event
     * @return bool
     */
    public function removeEvent(EventInterface $event)
    {
        return $this->getEventFollower()->removeEvent($event);
    }
    
    public function getEvents()
    {
        return $this->getEventFollower()->getEvents();
    }
    
    public function getLastEvent($name)
    {
        return $this->getEventFollower()->getLastEvent($name);
    }
    
    /**
     *
     * @return EventFollowerInterface
     */
    public function getEventFollower()
    {
        if ($this->eventFollower === null) {
            $this->setEventFollower(new EventFollower()); // @todo change to create
        }
        
        return $this->eventFollower;
    }
    
    /**
     *
     * @param EventFollowerInterface $eventFollower
     * @return self
     */
    public function setEventFollower(EventFollowerInterface $eventFollower)
    {
        $this->eventFollower = $eventFollower;
    
        return $this;
    }
    
    /**
     * Set creation
     *
     * @param \DateTime $creation
     * @return self
     */
    public function setCreation(\DateTime $creation)
    {
        $this->creation = $creation;
    
        return $this;
    }

    /**
     * Get creation
     *
     * @return \DateTime
     */
    public function getCreation()
    {
        return $this->creation;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return self
     */
    public function setNumber($number)
    {
        $this->number = $number;
    
        return $this;
    }
    
    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }
    
    /**
     * Set trusteeName
     * @deprecated Use getCustomerName($name)
     * @param string $trusteeName
     * @return self
     */
    public function setTrusteeName($trusteeName)
    {
        return $this->setCustomerName($trusteeName);
    }

    /**
     * Get trusteeName
     * @deprecated Use getCustomerName()
     * @return string
     */
    public function getTrusteeName()
    {
        return $this->getCustomerName();
    }

    /**
     * Set customerName
     *
     * @param string $name
     * @return self
     */
    public function setCustomerName($name)
    {
        $this->trusteeName = $name;
    
        return $this;
    }
    
    /**
     * Get customerName
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->trusteeName;
    }
    
    /**
     * Set trusteeAddress
     * @deprecated Use setCustomerAddress($address)
     * @param string $trusteeAddress
     * @return self
     */
    public function setTrusteeAddress($trusteeAddress)
    {
        return $this->setCustomerAddress($trusteeAddress);
    }

    /**
     * Get trusteeAddress
     * @deprecated Use getCustomerAddress()
     * @return string
     */
    public function getTrusteeAddress()
    {
        return $this->getCustomerAddress();
    }
    
    /**
     * Set customerAddress
     *
     * @param string $customerAddress
     * @return self
     */
    public function setCustomerAddress($address)
    {
        $this->trusteeAddress = $address;
    
        return $this;
    }
    
    /**
     * Get customerAddress
     *
     * @return string
     */
    public function getCustomerAddress()
    {
        return $this->trusteeAddress;
    }

    /**
     * Set trustee
     * @deprecated Use setCustomer($customer)
     * @param CustomerInterface $trustee
     * @return self
     */
    public function setTrustee(CustomerInterface $trustee = null)
    {
        return $this->setCustomer($trustee);
    }

    /**
     * Get trustee
     * @deprecated Use getCustomer()
     * @return CustomerInterface
     */
    public function getTrustee()
    {
        return $this->getCustomer();
    }
    
    /**
     * Get customer
     *
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->trustee;
    }
    
    /**
     * Set customer
     *
     * @param CustomerInterface|null $customer
     * @return self
     */
    public function setCustomer(CustomerInterface $customer = null)
    {
        $this->trustee = $customer;
        
        return $this;
    }
    
    /**
     * Set vat
     *
     * @param float $vat
     * @return self
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    
        return $this;
    }
    
    /**
     * Get vat
     *
     * @return float
     */
    public function getVat()
    {
        return $this->vat;
    }
    
    /**
     * Set vatTransmitter
     * @deprecated Must found another method
     * @param float $vatTransmitter
     * @return self
     */
    public function setVatTransmitter($vat)
    {
        $this->vatTransmitter = $vat;
    
        return $this;
    }
    
    /**
     * Get vatTransmitter
     * @deprecated Must found another method
     * @return float
     */
    public function getVatTransmitter()
    {
        return $this->vatTransmitter;
    }
}
