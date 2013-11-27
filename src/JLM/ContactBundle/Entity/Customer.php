<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class CustomerException extends \Exception {}

/**
 * Customer
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Customer
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
     * @var integer
     *
     * @ORM\Column(name="accountNumber", type="integer", nullable=true)
     */
    private $accountNumber;

    /**
     * @var Contact
     * 
     * @ORM\OneToOne(targetEntity="Contact")
     */
    private $contact;

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
     * Set accountNumber
     *
     * @param integer $accountNumber
     * @return Customer
     */
    public function setAccountNumber($accountNumber)
    {
    	if (!preg_match('#^[0-9]*$#',$accountNumber))
    		throw new CustomerException('Account number unvalid');
        $this->accountNumber = empty($accountNumber) ? null : (int)$accountNumber;
        return $this;
    }

    /**
     * Get accountNumber
     *
     * @return integer|null
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Set contact
     *
     * @param \JLM\ContactBundle\Entity\Contact $contact
     * @return Customer
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