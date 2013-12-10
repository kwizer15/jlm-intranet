<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Model\AddressInterface;
use JLM\ContactBundle\Model\ContactInterface;
use JLM\BillBundle\Model\BillableContact;

class CustomerException extends \Exception {}

/**
 * Customer
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Customer implements BillableContact
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
     * @var string|null
     * 
     * @ORM\Column(name="billing_name", type="string", nullable=true)
     */
    private $billingName;
    
    /**
     * @var AddressInterface
     *
     * @ORM\Column(targetEntity="JLM\ContactBundle\Model\AddressInterface")
     */
    private $billingAddress;
    
    /**
     * Constructor
     * @param ContactInterface $contact
     */
    public function __construct(ContactInterface $contact)
    {
    	$this->contact = $contact;
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
     * Get name
     */
    public function getName()
    {
    	return $this->contact->getName();
    }
    
    /**
     * Set billing name
     * @param string $name
     */
    public function setBillingName($name = null)
    {
    	$this->billingName = $name;
    	return $this;
    }
    
    /**
     * Get billing name
     */
    public function getBillingName()
    {
    	return ($this->billingName === null) ? $this->getName() : $this->billingName;
    }
    
    /**
     * Set billing address
     * @param AddressInterface|null $address
     * @return self
     */
    public function setBillingAddress(AddressInterface $address = null)
    {
    	$this->billingAddress = $address;
    	return $this;
    }
    
    /**
     * Get billing address
     * @return AddressInterface
     */
    public function getBillingAddress()
    {
    	return ($this->billingAddress === null) ? $this->getMainAddress() : $this->billingAddress;
    }
    
    /**
     * Get Main address
     * @return AddressInterface
     */
    public function getMainAddress()
    {
    	return $this->contact->getMainAddress();
    }
}