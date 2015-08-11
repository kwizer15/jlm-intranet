<?php

/*
 * This file is part of the JLMFeeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FeeBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use JLM\CommerceBundle\Model\VATInterface;
use JLM\ModelBundle\Entity\Trustee;
use JLM\ProductBundle\Model\ProductInterface;
use JLM\FeeBundle\Model\FeesFollowerInterface;
use JLM\ContractBundle\Model\ContractInterface;
use JLM\FeeBundle\Model\FeeInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Fee implements FeeInterface
{
	/**
	 * @var int $id
     */
    private $id;
	
	/**
	 * @var ArrayCollection $contracts
	 * @Assert\Valid(traverse=true)
	 */
	private $contracts;
	
	/**
	 * @var Trustee $trustee
	 * @Assert\Valid
	 */
	private $trustee;
	
	/**
	 * @var string $address
	 * @Assert\Type(type="string")
	 * @Assert\NotNull
	 */
	private $address;
	
	/**
	 * @var string $prelabel
	 * @Assert\Type(type="string")
	 */
	private $prelabel;
	
	/**
	 * @var int $frequence
	 * @Assert\Choice(choices={1,2,3,4})
	 * @Assert\NotNull
	 */
	private $frequence = 2;
	
	/**
	 * @var Vat $vat
	 * @Assert\Valid
	 */
	private $vat;
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contracts = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set address
     *
     * @param string $address
     * @return Fee
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set prelabel
     *
     * @param string $prelabel
     * @return Fee
     */
    public function setPrelabel($prelabel)
    {
        $this->prelabel = $prelabel;
    
        return $this;
    }

    /**
     * Get prelabel
     *
     * @return string 
     */
    public function getPrelabel()
    {
        return $this->prelabel;
    }

    /**
     * Set frequence
     *
     * @param int $frequence
     * @return Fee
     */
    public function setFrequence($frequence)
    {
    	$values = array(1,2,4);
    	if (in_array($frequence, $values))
    	{
    		$this->frequence = $frequence;
    	}
    	return $this;
    }
    
    /**
     * Get frequence
     *
     * @return int
     */
    public function getFrequence()
    {
    	return $this->frequence;
    }
    
    /**
     * Get frequence string
     *
     * @return string
     */
    public function getFrequenceString()
    {
    	switch ($this->getFrequence())
    	{
    		case 1:
    			return 'annuelle';
    			break;
    		case 4:
    			return 'trimestrielle';
    			break;
    	}
    	
    	return 'semestrielle';
    }
    
    /**
     * Set VatInterface
     * @return Fee
     */
    public function setVat(VATInterface $vat)
    {
    	$this->vat = $vat;
    	
    	return $this;
    }
    
    /**
     * Get Vat
     * @return VAT
     */
    public function getVat()
    {
    	return $this->vat;
    }
    
    /**
     * Add contract
     *
     * @param ContractInterface $contract
     * @return Fee
     */
    public function addContract(ContractInterface $contract)
    {
        $this->contracts[] = $contract;
    
        return true;
    }

    /**
     * Remove contract
     *
     * @param ContractInterface $contract
     */
    public function removeContract(ContractInterface $contract)
    {
        return $this->contracts->removeElement($contract);
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
     * Get contracts
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getActiveContracts(\DateTime $date)
    {
    	$contracts = array();
    	foreach ($this->contracts as $contract)
    	{
    		if ($contract->isInProgress($date))
    		{
    			$contracts[] = $contract;
    		}
    	}
    	
    	return $contracts;
    }
    
    /**
     * Set trustee
     *
     * @param JLM\ModelBundle\Entity\Trustee $trustee
     * @return Fee
     */
    public function setTrustee(Trustee $trustee = null)
    {
        $this->trustee = $trustee;
    
        return $this;
    }

    /**
     * Get trustee
     *
     * @return JLM\ModelBundle\Entity\Trustee 
     */
    public function getTrustee()
    {
        return $this->trustee;
    }
    
    /**
     * Get Contract Numbers
     * @return array
     */
    public function getContractNumbers()
    {
    	$numbers = array();
    	foreach ($this->contracts as $contract)
    	{
    	    $num = $contract->getNumber();
    		if (!in_array($num, $numbers))
    		{
    			$numbers[] = $num;
    		}
    	}
    	return $numbers;
    }
    
    /**
     * Get Descriptif des portes
     * @return string
     */
    public function getDoorDescription()
    {
    	$doors = array();
    	foreach ($this->contracts as $contract)
    	{
    		$install = $contract->getDoor();
    		$doors[] = $install->getType().' / '.$install->getLocation();
    	}
    	return $doors;
    }
    
    /**
     * Get BillingAddress
     * @return Address
     */
    public function getBillingAddress()
    {
    	$trustee = $this->getTrustee();
		if ($billingaddress = $trustee->getBillingAddress())
		{
			if ($billingaddress->getStreet() && $billingaddress->getCity() !== null)
			{
				return $billingaddress;
			}
		}
		
		return $trustee->getAddress();
    }
    
    /**
     * Get Amount
     * @return float
     */
    public function getYearAmount()
    {
    	$amount = 0;
    	foreach ($this->contracts as $contract)
    	{
    		$amount += $contract->getFee();
    	}
    	return $amount;
    }
    
    /**
     * Get Amount
     * @return float
     */
    public function getAmount()
    {
    	return $this->getYearAmount() / $this->getFrequence();
    }
   
    /**
     * Get Reference
     */
    public function getGroup()
    {
    	$group = '';
    	foreach ($this->contracts as $contract)
    	{
    		$group .= $contract->getDoor()->getSite()->getGroupNumber();
    		if ($group != '')
    		{
    			$group .= ' ';
    		}
    	}
    	
    	return trim($group);
    }
    
    /**
     * 
     * @return array
     */
    public function getManagerEmails()
    {
    	$emails = array();
    	foreach ($this->contracts as $contract)
    	{
    		$mails = $contract->getDoor()->getManagerEmails();
    		$mails = ($mails === null) ? array() : $mails;
    		foreach($mails as $mail)
    		{
    			if (!in_array($mail, $emails))
    			{
    				$emails[] = $mail;
    			}
    		}
    	}
    	
    	return $emails;
    }
    
    /**
     *
     * @return array
     */
    public function setManagerEmails($emails)
    {
    	return $this;
    }
    
    /**
     * 
     * @return array
     */
    public function getAccountingEmails()
    {
    	$emails = array();
    	foreach ($this->contracts as $contract)
    	{
    		$mails = $contract->getDoor()->getAccountingEmails();
    		$mails = ($mails === null) ? array() : $mails;
    		foreach($mails as $mail)
    		{
    			if (!in_array($mail, $emails))
    			{
    				$emails[] = $mail;
    			}
    		}
    	}
    	
    	return $emails;
    }
    
    /**
     *
     * @return array
     */
    public function setAccountingEmails($emails)
    {
    	return $this;
    }
}
