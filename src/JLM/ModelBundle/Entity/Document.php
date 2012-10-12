<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Document
 *
 * @ORM\Table(name="documents")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 * 		"quote" = "Quote"
 * })
 */
abstract class Document
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
     * @var Collaborator $follower
     * 
     * @ORM\ManyToOne(targetEntity="Employee")
     */
    private $follower;
    
    /**
     * @var Trustee $trustee
     *
     * @ORM\ManyToOne(targetEntity="Trustee")
     */
    private $trustee;
       
    /**
     * @var Door $door
     *
     * @ORM\ManyToMany(targetEntity="Door", inversedBy="documents")
     * @ORM\JoinTable(name="documents_doors")
     */
    private $door;
    
    /**
     * @var datetime $creation
     *
     * @ORM\Column(name="creation", type="datetime")
     */
    private $creation;

    /**
     * @var string $trusteeName
     *
     * @ORM\Column(name="trustee_name", type="string", length=255)
     */
    private $trusteeName;
    
    /**
     * @var string $trusteeStreet
     * 
     * @ORM\Column(name="trustee_street", type="string", length=255)
     */
    private $trusteeStreet;
    
    /**
     * @var string $trusteeZip
     *
     * @ORM\Column(name="trustee_zip", type="string", length=255)
     */
    private $trusteeZip;
    
    /**
     * @var string $trusteeCity
     *
     * @ORM\Column(name="trustee_city", type="string", length=255)
     */
    private $trusteeCity;
    
    /**
     * @var string $trusteeInterlocutor
     *
     * @ORM\Column(name="trustee_interlocutor", type="string", length=255)
     */
    private $trusteeInterlocutor;

    /**
     * @var DocumentContent[] $contents
     * 
     * @ORM\OneToMany(targetEntity="DocumentContent", mappedBy="document")
     */
    private $contents;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->contents = new ArrayCollection;
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
     * Set creation
     *
     * @param datetime $creation
     */
    public function setCreation($creation)
    {
        $this->creation = $creation;
    }

    /**
     * Get creation
     *
     * @return datetime 
     */
    public function getCreation()
    {
        return $this->creation;
    }

    /**
     * Set trusteeName
     *
     * @param string $trusteeName
     */
    public function setTrusteeName($trusteeName)
    {
        $this->trusteeName = $trusteeName;
    }

    /**
     * Get trusteeName
     *
     * @return string 
     */
    public function getTrusteeName()
    {
        return $this->trusteeName;
    }

    /**
     * Set trusteeStreet
     *
     * @param string $trusteeStreet
     */
    public function setTrusteeStreet($trusteeStreet)
    {
        $this->trusteeStreet = $trusteeStreet;
    }

    /**
     * Get trusteeStreet
     *
     * @return string 
     */
    public function getTrusteeStreet()
    {
        return $this->trusteeStreet;
    }

    /**
     * Set trusteeZip
     *
     * @param string $trusteeZip
     */
    public function setTrusteeZip($trusteeZip)
    {
        $this->trusteeZip = $trusteeZip;
    }

    /**
     * Get trusteeZip
     *
     * @return string 
     */
    public function getTrusteeZip()
    {
        return $this->trusteeZip;
    }

    /**
     * Set trusteeCity
     *
     * @param string $trusteeCity
     */
    public function setTrusteeCity($trusteeCity)
    {
        $this->trusteeCity = $trusteeCity;
    }

    /**
     * Get trusteeCity
     *
     * @return string 
     */
    public function getTrusteeCity()
    {
        return $this->trusteeCity;
    }

    /**
     * Set trusteeInterlocutor
     *
     * @param string $trusteeInterlocutor
     */
    public function setTrusteeInterlocutor($trusteeInterlocutor)
    {
        $this->trusteeInterlocutor = $trusteeInterlocutor;
    }

    /**
     * Get trusteeInterlocutor
     *
     * @return string 
     */
    public function getTrusteeInterlocutor()
    {
        return $this->trusteeInterlocutor;
    }

    /**
     * Set follower
     *
     * @param JLM\ModelBundle\Entity\Collaborator $follower
     */
    public function setFollower(\JLM\ModelBundle\Entity\Collaborator $follower)
    {
        $this->follower = $follower;
    }

    /**
     * Get follower
     *
     * @return JLM\ModelBundle\Entity\Collaborator 
     */
    public function getFollower()
    {
        return $this->follower;
    }

    /**
     * Set trustee
     *
     * @param JLM\ModelBundle\Entity\Trustee $trustee
     */
    public function setTrustee(\JLM\ModelBundle\Entity\Trustee $trustee)
    {
        $this->trustee = $trustee;
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
     * Add contents
     *
     * @param JLM\ModelBundle\Entity\DocumentContent $contents
     */
    public function addDocumentContent(\JLM\ModelBundle\Entity\DocumentContent $contents)
    {
        $this->contents[] = $contents;
    }

    /**
     * Get contents
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Get door
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDoor()
    {
        return $this->door;
    }
}