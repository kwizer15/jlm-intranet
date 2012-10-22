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
     * @var boolean $accession
     * true = accession
     * false = social
     * null = unknown
     * @ORM\Column(name="accession", type="boolean")
     */
    private $accession;

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
    	$this->documents = new ArrayCollection;
    	$this->contracts = new ArrayCollection;
    }

    /**
     * Set accession
     *
     * @param boolean $accession
     */
    public function setAccession($accession)
    {
        $this->accession = $accession;
    }

    /**
     * Get accession
     *
     * @return boolean 
     */
    public function getAccession()
    {
        return $this->accession;
    }

    /**
     * Set accountNumber
     *
     * @param integer $accountNumber
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
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
     * Add contracts
     *
     * @param JLM\ModelBundle\Entity\Contract $contracts
     */
    public function addContract(\JLM\ModelBundle\Entity\Contract $contracts)
    {
        $this->contracts[] = $contracts;
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
     * Add documents
     *
     * @param JLM\ModelBundle\Entity\Document $documents
     */
    public function addDocument(\JLM\ModelBundle\Entity\Document $documents)
    {
        $this->documents[] = $documents;
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
     */
    public function setBillingAddress(\JLM\ModelBundle\Entity\Address $billingAddress)
    {
        $this->billingAddress = $billingAddress;
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
    
    /**
     * Set phone
     *
     * @param string $billingPhone
     */
    public function setBillingPhone($phone)
    {
    	$this->billingPhone = $phone;
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
     * @param string $fax
     */
    public function setBillingFax($fax)
    {
    	$this->billingFax = $fax;
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
     * @param string $email
     */
    public function setBillingEmail($email)
    {
    	$this->billingEmail = $email;
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
    

}