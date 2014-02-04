<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Model\ContactInterface;
use JLM\ContactBundle\Model\AddressInterface;
use JLM\ContactBundle\Model\BillableContact;

class CustomerException extends \Exception {}

/**
 * Customer
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Customer extends ContactDecorator implements ContactInterface, BillableContact
{
    
    /**
     * @var integer
     *
     * @ORM\Column(name="accountNumber", type="integer", nullable=true)
     */
    private $accountNumber;

    /**
     * @var string|null
     * 
     * @ORM\Column(name="billing_name", type="string", nullable=true)
     */
    private $billingName;
    
    /**
     * @var AddressInterface
     *
     * @ORM\ManyToOne(targetEntity="JLM\ContactBundle\Model\AddressInterface")
     */
    private $billingAddress;

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
}