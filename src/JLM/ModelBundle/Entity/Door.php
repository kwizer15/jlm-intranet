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
     * @var string $address_street
     * 
     * @ORM\OneToOne(targetEntity="Address",cascade={"all"})
     */
    private $address;
    
    /**
     * @var Contract[] $contracts
     * 
     * @ORM\OneToMany(targetEntity="Contract", mappedBy="door")
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
     * @var string $transmitters
     * 
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinTable(name="doors_transmitters",
     * 		joinColumns={@ORM\JoinColumn(name="door_id", referencedColumnName="id")},
     * 		inverseJoinColumns={@ORM\JoinColumn(name="transmitters_id", referencedColumnName="id")}
     * 		)
     */
    private $transmitters;
   
    /**
     * @var Document[] $documents
     *
     * @ORM\OneToMany(targetEntity="Document",mappedBy="trustee")
     */
    private $documents;
    
    /**
     * @var float latitude
     * 
     * @ORM\Column(name="latitude", type="decimal",scale="7",nullable=true)
     */
    private $latitude;
    
    /**
     * @var float longitude
     *
     * @ORM\Column(name="longitude", type="decimal",scale="7",nullable=true)
     */
    private $longitude;
    
    /**
     * @var Person[] $contacts
     *
     * @ORM\ManyToMany(targetEntity="Person",cascade={"all"})
     * @ORM\JoinTable(name="doors_contacts",
     *      joinColumns={@ORM\JoinColumn(name="door_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $contacts;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->contacts = new ArrayCollection;
    	$this->trustees = new ArrayCollection;
    	$this->contracts = new ArrayCollection;
    	$this->parts = new ArrayCollection;
    	$this->documents = new ArrayCollection;
    	$this->transmitters = new ArrayCollection;
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
     * Add contacts
     *
     * @param JLM\ModelBundle\Entity\Person $contacts
     */
    public function addContact(\JLM\ModelBundle\Entity\Person $contacts)
    {
    	$this->contacts[] = $contacts;
    }
    
    /**
     * Get contacts
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
    	return $this->contacts;
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
     * Set latitude
     *
     * @param decimal $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Get latitude
     *
     * @return decimal 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param decimal $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Get longitude
     *
     * @return decimal 
     */
    public function getLongitude()
    {
        return $this->longitude;
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
     * Get transmitters
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTransmitters()
    {
        return $this->transmitters;
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