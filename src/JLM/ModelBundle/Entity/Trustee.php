<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Trustee
 *
 * @ORM\Table()
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
     * @ORM\ManyToMany(targetEntity="Door", inversedBy="trustees")
     * @ORM\JoinTable(name="trustees_doors")
     */
    private $doors;

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
}