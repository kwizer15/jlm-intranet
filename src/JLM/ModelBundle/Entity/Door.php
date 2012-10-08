<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Door
 *
 * @ORM\Table()
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
     * @ORM\OneToMany(targetEntity="Contract", mappedBy="door")
     */
    private $contracts;
    
    /**
     * @var DoorType $type
     * 
     * @ORM\ManyToOne(tragetEntity="DoorType")
     */
    private $type;
    
    /**
     * @var string $location
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var string transmitters
     * @todo Voir quel type d'objet pour ca
     * @ORM\Column(name="transmitter",type="string",length=255)
     */
    private $transmitters;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->trustees = new ArrayCollection;
    	$this->contracts = new ArrayCollection;
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
}