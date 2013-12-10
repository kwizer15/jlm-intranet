<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Model\AddressInterface;
use JLM\ContactBundle\Model\ContactInterface;
use JLM\ContactBundle\Model\ContactAddressInterface;
use JLM\ContactBundle\Model\ContactEmailInterface;
use JLM\ContactBundle\Model\ContactPhoneInterface;
use JLM\ContactBundle\Model\BillableContact;

class CustomerException extends \Exception {}

/**
 * Customer
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Customer implements ContactInterface, BillableContact
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
     * Set billing name
     * @param string $name
     */
    public function setBillingName($name = null)
    {
    	$this->billingName = $name;
    	return $this;
    }
    
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getBillingAddress()
    {
    	return ($this->billingAddress === null) ? (string)$this->getMainAddress() : (string)$this->billingAddress;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
    	return $this->contact->getName();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMainAddress()
    {
    	return $this->contact->getMainAddress();
    }
    
    /**
     * {@inheritdoc}
     */
    public function addEmail(ContactEmailInterface $email)
    {
    	$this->contact->addEmail($email);
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeEmail(ContactEmailInterface $email)
    {
    	$this->contact->removeEmail($email);
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEmails()
    {
    	return $this->contact->getEmails();
    }
    
    /**
     * {@inheritdoc}
     */
    public function addAddress(ContactAddressInterface $address)
    {
    	$this->contact->addAddress($address);
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeAddress(ContactAddressInterface $address)
    {
    	$this->contact->removeAddress($address);
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAddresses()
    {
    	return $this->contact->getAddresses();
    }
    
    /**
     * {@inheritdoc}
     */
    public function addPhone(ContactPhoneInterface $phone)
    {
    	$this->contact->addPhone($phone);
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removePhone(ContactPhoneInterface $phone)
    {
    	$this->contact->removePhone($phone);
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPhones()
    {
    	return $this->contact->getPhones();
    }
}