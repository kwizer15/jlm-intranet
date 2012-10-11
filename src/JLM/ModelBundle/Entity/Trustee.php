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
class Trustee
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Interlocutor[] $interlocutors
     * 
     * @ORM\OneToMany(targetEntity="Interlocutor", mappedBy="trustee")
     */
    private $interlocutors;
    
    /**
     * @var Address $mainAddress
     *
     * @ORM\ManyToOne(targetEntity="Address")
     */
    private $mainAddress;
    
    /**
     * @var Address $billingAddress
     * 
     * @ORM\ManyToOne(targetEntity="Address")
     */
    private $billingAddress;
    
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
     * Constructor
     */
    public function __construct()
    {
    	$this->interlocutors = new ArrayCollection;
    	$this->doors = new ArrayCollection;
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
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
     * Add interlocutors
     *
     * @param JLM\ModelBundle\Entity\Interlocutor $interlocutors
     */
    public function addInterlocutor(\JLM\ModelBundle\Entity\Interlocutor $interlocutors)
    {
        $this->interlocutors[] = $interlocutors;
    }

    /**
     * Get interlocutors
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getInterlocutors()
    {
        return $this->interlocutors;
    }

    /**
     * Set mainAddress
     *
     * @param JLM\ModelBundle\Entity\Address $mainAddress
     */
    public function setMainAddress(\JLM\ModelBundle\Entity\Address $mainAddress)
    {
        $this->mainAddress = $mainAddress;
    }

    /**
     * Get mainAddress
     *
     * @return JLM\ModelBundle\Entity\Address 
     */
    public function getMainAddress()
    {
        return $this->mainAddress;
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
     * Add doors
     *
     * @param JLM\ModelBundle\Entity\Door $doors
     */
    public function addDoor(\JLM\ModelBundle\Entity\Door $doors)
    {
        $this->doors[] = $doors;
    }

    /**
     * Get doors
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDoors()
    {
        return $this->doors;
    }
    
    /**
     * To String
     */
    public function __toString()
    {
    	return $this->name;
    }
}