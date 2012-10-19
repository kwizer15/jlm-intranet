<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Trustee
 *
 * @ORM\Table(name="trustees")
 * @ORM\Entity
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
     * Constructor
     */
    public function __construct()
    {
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
}