<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Trustee
 *
 * @ORM\Table(name="trustees")
 * @ORM\Entity(repositoryClass="JLM\ModelBundle\Entity\TrusteeRepository")
 */
class Trustee extends Company
{


    /**
     * @var integer $accountNumber
     *
     * @ORM\Column(name="accountNumber", type="integer", nullable=true)
     * @Assert\Regex(pattern="/^411\d{3,5}$/",message="Ce n'est pas un numéro de compte valide.")
     */
    private $accountNumber;

    /**
     * @var ArrayCollection $contracts
     * 
     * @ORM\OneToMany(targetEntity="Contract", mappedBy="trustee")
     */
    private $contracts;

    /**
     * @var ArrayCollection $sites
     * 
     * @ORM\OneToMany(targetEntity="Site",mappedBy="trustee")
     */
    private $sites;
    

    /**
     * Libelé de facturation
     * @var string $billingLabel
     * 
     * @ORM\Column(name="billingLabel", type="string", nullable=true)
     * @Assert\Type(type="string")
     */
    private $billingLabel;
    
    /**
     * Adresse de facturation (si differente)
     * @var Address $billingAddress
     *
     * @ORM\OneToOne(targetEntity="Address")
     */
    private $billingAddress;
    
    /**
     * @var string $phone
     *
     * @ORM\Column(name="billingPhone",type="string",length=20, nullable=true)
     * @Assert\Regex(pattern="/^0[1-9]\d{8}$/",message="Ce n'est pas un numéro de téléphone fixe valide")
     */
    private $billingPhone;
    
    /**
     * @var string $fax
     *
     * @ORM\Column(name="billingFax",type="string",length=20, nullable=true)
     * @Assert\Regex(pattern="/^0[1-9]\d{8}$/",message="Ce n'est pas un numéro de fax valide")
     */
    private $billingFax;
    
    /**
     * @var email $email
     *
     * @ORM\Column(name="billingEmail",type="string",length=255, nullable=true)
     * @Assert\Email
     */
    private $billingEmail;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	parent::__construct();
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
     * @param JLM\ModelBundle\Entity\Contract $contracts
     * @return Trustee
     */
    public function addContract(\JLM\ModelBundle\Entity\Contract $contracts)
    {
        $this->contracts[] = $contracts;
    
        return $this;
    }

    /**
     * Remove contracts
     *
     * @param JLM\ModelBundle\Entity\Contract $contracts
     */
    public function removeContract(\JLM\ModelBundle\Entity\Contract $contracts)
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
     * @param JLM\ModelBundle\Entity\Address $billingAddress
     * @return Trustee
     */
    public function setBillingAddress(\JLM\ModelBundle\Entity\Address $billingAddress = null)
    {
        $this->billingAddress = $billingAddress;
    
        return $this;
    }

    /**
     * Get billingAddress
     *
     * @return JLM\ModelBundle\Entity\Address 
     */
    public function getBillingAddress()
    {
    	return $this->billingAddress;
        
    }
    
    public function getAddressForBill()
    {
    	if ($this->billingAddress)
    		if ($this->billingAddress->getStreet())
    			return $this->billingAddress;
    	return $this->getAddress();
    }
    
    /**
     * Get BillingLabel
     * 
     * @return string
     */
    public function getBillingLabel()
    {
    	if ($this->billingLabel === null)
    		return $this->getName();
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
}