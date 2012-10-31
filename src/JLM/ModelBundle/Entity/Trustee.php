<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
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
     * @ORM\Column(name="accountNumber", type="integer")
     */
    private $accountNumber;

    /**
     * @var Door[] $doors
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
     * @var Document[] $documents
     *
     * @ORM\OneToMany(targetEntity="Document",mappedBy="trustee")
     */
    private $documents;
    
    
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
     */
    private $billingPhone;
    
    /**
     * @var string $fax
     *
     * @ORM\Column(name="billingFax",type="string",length=20, nullable=true)
     */
    private $billingFax;
    
    /**
     * @var email $email
     *
     * @ORM\Column(name="billingEmail",type="string",length=255, nullable=true)
     */
    private $billingEmail;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	parent::__construct();
    	$this->sites = new ArrayCollection;
    	$this->documents = new ArrayCollection;
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
     * Add documents
     *
     * @param JLM\ModelBundle\Entity\Document $documents
     * @return Trustee
     */
    public function addDocument(\JLM\ModelBundle\Entity\Document $documents)
    {
        $this->documents[] = $documents;
    
        return $this;
    }

    /**
     * Remove documents
     *
     * @param JLM\ModelBundle\Entity\Document $documents
     */
    public function removeDocument(\JLM\ModelBundle\Entity\Document $documents)
    {
        $this->documents->removeElement($documents);
    }

    /**
     * Get documents
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDocuments()
    {
        return $this->documents;
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
    	if ($this->billingAddress instanceof Address)
    		if ($this->billingAddress->getCity() === null)
    			return $this->getAddress();
        return $this->billingAddress;
    }
}