<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Door
 *
 * @ORM\Table(name="doors")
 * @ORM\Entity
 */
class Door
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
     * @var Trustee[] $trustees
     * 
     * @ORM\ManyToMany(targetEntity="Trustee", mappedBy="doors")
     */
    private $trustees;
    
    /**
     * @var Address $address
     * 
     * @ORM\ManyToOne(targetEntity="Address")
     */
    private $address;
    
    /**
     * @var Contract[] $contracts
     * 
     * @ORM\ManyToMany(targetEntity="Contract", mappedBy="doors")
     */
    private $contracts;
    
    /**
     * @var DoorType $type
     * 
     * @ORM\ManyToOne(targetEntity="DoorType")
     */
    private $type;
    
    /**
     * @var string $location
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var Product[] $parts
     * 
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinTable(name="doors_parts",
     *      joinColumns={@ORM\JoinColumn(name="door_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="part_id", referencedColumnName="id")}
     *      )
     */
    private $parts;
    
    /**
     * @var string transmitters
     * @todo Voir quel type d'objet pour ca
     * 
     * @ORM\Column(name="transmitter",type="string",length=255)
     */
    private $transmitters;
    
    /**
     * @var Document[] $documents
     * 
     * @ORM\ManyToMany(targetEntity="Document",mappedBy="doors")
     */
    private $documents;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->trustees = new ArrayCollection;
    	$this->contracts = new ArrayCollection;
    	$this->parts = new ArrayCollection;
    	$this->documents = new ArrayCollection;
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
     * Set location
     *
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set transmitters
     *
     * @param string $transmitters
     */
    public function setTransmitters($transmitters)
    {
        $this->transmitters = $transmitters;
    }

    /**
     * Get transmitters
     *
     * @return string 
     */
    public function getTransmitters()
    {
        return $this->transmitters;
    }

    /**
     * Add trustees
     *
     * @param JLM\ModelBundle\Entity\Trustee $trustees
     */
    public function addTrustee(\JLM\ModelBundle\Entity\Trustee $trustees)
    {
        $this->trustees[] = $trustees;
    }

    /**
     * Get trustees
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTrustees()
    {
        return $this->trustees;
    }

    /**
     * Set address
     *
     * @param JLM\ModelBundle\Entity\Address $address
     */
    public function setAddress(\JLM\ModelBundle\Entity\Address $address)
    {
        $this->address = $address;
    }

    /**
     * Get address
     *
     * @return JLM\ModelBundle\Entity\Address 
     */
    public function getAddress()
    {
        return $this->address;
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
     * Set type
     *
     * @param JLM\ModelBundle\Entity\DoorType $type
     */
    public function setType(\JLM\ModelBundle\Entity\DoorType $type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return JLM\ModelBundle\Entity\DoorType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add parts
     *
     * @param JLM\ModelBundle\Entity\Product $parts
     */
    public function addProduct(\JLM\ModelBundle\Entity\Product $parts)
    {
        $this->parts[] = $parts;
    }

    /**
     * Get parts
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getParts()
    {
        return $this->parts;
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
}