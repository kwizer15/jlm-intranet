<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JLM\ContactBundle\Model\AddressInterface;
use JLM\CondominiumBundle\Model\ManagerInterface;
use JLM\ContractBundle\Model\ContractInterface;
use JLM\CommerceBundle\Model\CustomerInterface;
use JLM\AskBundle\Model\PayerInterface;
use JLM\ContactBundle\Entity\ContactDecorator;
use JLM\ContactBundle\Model\ContactInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Trustee extends ContactDecorator implements ManagerInterface, CustomerInterface, PayerInterface
{
    /**
     * @var integer $accountNumber
     * 
     * @Assert\Regex(pattern="/^411\d{3,5}$/",message="Ce n'est pas un numéro de compte valide.")
     */
    private $accountNumber;

    /**
     * @var ArrayCollection $contracts
     */
    private $contracts;

    /**
     * @var ArrayCollection $sites
     */
    private $sites;   

    /**
     * Libelé de facturation
     * @var string $billingLabel
     * 
     * @Assert\Type(type="string")
     */
    private $billingLabel;
    
    /**
     * Adresse de facturation (si differente)
     * @var AddressInterface $billingAddress
     */
    private $billingAddress;
    
    /**
     * @var string $phone
     * 
     * @Assert\Regex(pattern="/^0[1-9]\d{8}$/",message="Ce n'est pas un numéro de téléphone fixe valide")
     */
    private $billingPhone;
    
    /**
     * @var string $fax
     * 
     * @Assert\Regex(pattern="/^0[1-9]\d{8}$/",message="Ce n'est pas un numéro de fax valide")
     */
    private $billingFax;
    
    /**
     * @var string $email
     * 
     * @Assert\Email
     */
    private $billingEmail;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->sites = new ArrayCollection;
    	$this->contracts = new ArrayCollection;
    }
   
    /**
     * Set accountNumber
     *
     * @param integer $accountNumber
     * @return Trustee
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
    
        return $this;
    }

    /**
     * Get accountNumber
     *
     * @return integer 
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Set billingPhone
     *
     * @param string $billingPhone
     * @return Trustee
     */
    public function setBillingPhone($billingPhone)
    {
        $this->billingPhone = $billingPhone;
    
        return $this;
    }

    /**
     * Get billingPhone
     *
     * @return string 
     */
    public function getBillingPhone()
    {
        return $this->billingPhone;
    }

    /**
     * Set billingFax
     *
     * @param string $billingFax
     * @return Trustee
     */
    public function setBillingFax($billingFax)
    {
        $this->billingFax = $billingFax;
    
        return $this;
    }

    /**
     * Get billingFax
     *
     * @return string 
     */
    public function getBillingFax()
    {
        return $this->billingFax;
    }

    /**
     * Set billingEmail
     *
     * @param string $billingEmail
     * @return Trustee
     */
    public function setBillingEmail($billingEmail)
    {
        $this->billingEmail = $billingEmail;
    
        return $this;
    }

    /**
     * Get billingEmail
     *
     * @return string 
     */
    public function getBillingEmail()
    {
        return $this->billingEmail;
    }

    /**
     * Add contracts
     *
     * @param ContractInterface $contracts
     * @return Trustee
     */
    public function addContract(ContractInterface $contracts)
    {
        $this->contracts[] = $contracts;
    
        return $this;
    }

    /**
     * Remove contracts
     *
     * @param ContractInterface $contracts
     */
    public function removeContract(ContractInterface $contracts)
    {
        $this->contracts->removeElement($contracts);
    }

    /**
     * Get contracts
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getContracts()
    {
        return $this->contracts;
    }

    /**
     * Add sites
     *
     * @param JLM\ModelBundle\Entity\Site $sites
     * @return Trustee
     */
    public function addSite(\JLM\ModelBundle\Entity\Site $sites)
    {
        $this->sites[] = $sites;
    
        return $this;
    }

    /**
     * Remove sites
     *
     * @param JLM\ModelBundle\Entity\Site $sites
     */
    public function removeSite(\JLM\ModelBundle\Entity\Site $sites)
    {
        $this->sites->removeElement($sites);
    }

    /**
     * Get sites
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSites()
    {
        return $this->sites;
    }

    /**
     * Set billingAddress
     *
     * @param AddressInterface $billingAddress
     * @return Trustee
     */
    public function setBillingAddress(AddressInterface $billingAddress = null)
    {
        $this->billingAddress = $billingAddress;
    
        return $this;
    }

    /**
     * Get billingAddress
     *
     * @return AddressInterface
     */
    public function getBillingAddress()
    {
    	return $this->billingAddress;
        if ($this->billingAddress === null)
        {
            return $this->getAddress();
        }
        
    	return $this->billingAddress;
    }
    
    /**
     * Get bill address
     *
     * @return AddressInterface
     */
    public function getBillAddress()
    {
    	if ($this->billingAddress instanceof AddressInterface)
    	{
    		if ($this->billingAddress->getStreet())
    		{
    			return $this->billingAddress;
    		}
    	}
    	
    	return $this->getAddress();
    }
    
    /**
     * @deprecated Use getBillAddress
     * @return AddressInterface
     */
    public function getAddressForBill()
    {
    	return $this->getBillAddress();
    }
    
    /**
     * Get BillingLabel
     * @deprecated Use getBillLabel
     * @return string
     */
    public function getBillingLabel()
    {
    	return $this->billingLabel;
    }
    
    /**
     * Set billingLabel
     * 
     * @param string $label
     * @return Trustee
     */
    public function setBillingLabel($label)
    {
    	$this->billingLabel = $label;
    	
    	return $this;
    }
    
    /**
     * Get BillLabel
     * @return string
     */
    public function getBillLabel()
    {
    	return ($this->billingLabel == '') ? $this->getName() : $this->billingLabel;
    }
    
    /**
     * Get Contract Sum
     * @return float 
     */
    public function getContractsSum()
    {
    	$sum = 0;
    	foreach ($this->contracts as $contract)
    	{
    		if ($contract->getInProgress())
    			$sum += $contract->getFee();
    	}
    	return $sum;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getBillingName()
    {
        return $this->getBillingLabel();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getBillingBoostContacts()
    {
        return new ArrayCollection();
    }
}