<?php

/*
 * This file is part of the JLMBillBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\BillBundle\Entity;

use JLM\ContactBundle\Entity\ContactDecorator;
use JLM\ContactBundle\Model\ContactInterface;
use JLM\BillBundle\Model\BillableContactInterface;
use JLM\BillBundle\Model\BoostContactInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillableContact extends ContactDecorator implements BillableContactInterface
{
    /**
     * @var string
     */
    private $accountNumber;
    
    /**
     * Contacts de relance
     * @var BoostContacts
     */
    private $billingBoostContacts;
    
    public function __construct(ContactInterface $contact)
    {
        parent::__construct($contact);
        $this->billingBoostContacts = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }
    
    /**
     * Set the account number
     * @param string $number
     * @return self
     */
    public function setAccountNumber($number)
    {
        $this->accountNumber = $number;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getBillingBoostContacts()
    {
        return $this->billingBoostContacts;
    }
    
    /**
     * Add a boost contact
     * @param BoostContactInterface $contact
     * @return boolean
     */
    public function addBillingBoostContact(BoostContactInterface $contact)
    {
        $this->billingBoostContacts->add($contact);
        
        return true;
    }
    
    /**
     * Remove a boost contact
     * @param BoostContactInterface $contact
     * @return boolean
     */
    public function removeBillingBoostContact(BoostContactInterface $contact)
    {
        return $this->billingBoostContacts->removeElement($contact);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getBillingAddress()
    {
        return $this->getAddress();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getBillingName()
    {
        return $this->getName();
    }
}