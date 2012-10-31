<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Door
 *
 * @ORM\Table(name="doors")
 * @ORM\Entity(repositoryClass="JLM\ModelBundle\Entity\DoorRepository")
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
     * Batiment "officiel"
     * @var Site $site
     * 
     * @ORM\ManyToOne(targetEntity="Site")
     */
    private $site;
    
    /**
     * Indications internes
     * @var string $street
     * 
     * @ORM\Column(name="street",type="text")
     */
    private $street;
    
    /**
     * Contrats concernant la porte
     * @var Contract[] $contracts
     * 
     * ORM\ManyToMany(targetEntity="Contract", mappedBy="doors")
     */
   // private $contracts;
    
    /**
     * Type de porte
     * @var DoorType $type
     * 
     * @ORM\ManyToOne(targetEntity="DoorType")
     */
    private $type;
    
    /**
     * Localisation (ex: Entrée, façade...)
     * @var string $location
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * Pièces de la porte (cellules, bp...)
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
     * Emeteurs
     * @var Transmitter $transmitters
     * 
     * @ORM\ManyToMany(targetEntity="Transmitter")
     * @ORM\JoinTable(name="doors_transmitters",
     * 		joinColumns={@ORM\JoinColumn(name="door_id", referencedColumnName="id")},
     * 		inverseJoinColumns={@ORM\JoinColumn(name="transmitters_id", referencedColumnName="id")}
     * 		)
     */
    private $transmitters;
   
    /**
     * Devis concernant la porte
     * @var Document[] $documents
     *
     * @ORM\OneToMany(targetEntity="Document",mappedBy="trustee")
     */
    private $documents;
    
    /**
     * @var float Google Maps (Street)
     * 
     * @ORM\Column(name="googlemaps", type="text", nullable=true)
     */
    private $googlemaps;
    
    /**
     * Constructor
     */
    public function __construct()
    {
//    	$this->contracts = new ArrayCollection;
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
     * Set street
     *
     * @param string $street
     * @return Door
     */
    public function setStreet($street)
    {
        $this->street = $street;
    
        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Door
     */
    public function setLocation($location)
    {
        $this->location = $location;
    
        return $this;
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
     * Set googlemaps
     *
     * @param string $googlemaps
     * @return Door
     */
    public function setGooglemaps($url)
    {
        $this->googlemaps = $url;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getGooglemaps()
    {
        return $this->googlemaps;
    }
    
    /**
     * Get latitude
     *
     * @return float
     */
    public function getMapsUrl()
    {
    	list($url,$params) = explode('?',$this->googlemaps);
    	$parms = explode('&',$params);
    	foreach ($parms as $p)
    	{
    		list($key,$value) = explode('=',$p);
    		$arg[$key] = $value;
    	}

    	$url .= '?hl=fr&z=17&layer=c&output=svembed';
    	if (isset($arg['ll']))
    		$url .= '&ll='.$arg['ll'];
    	if (isset($arg['cbll']))
    		$url .= '&cbll='.$arg['cbll'];
    	if (isset($arg['cbp']))
    		$url .= '&cbp='.$arg['cbp'];
    	return $url;
    }

    /**
     * Set site
     *
     * @param JLM\ModelBundle\Entity\Site $site
     * @return Door
     */
    public function setSite(\JLM\ModelBundle\Entity\Site $site = null)
    {
        $this->site = $site;
    
        return $this;
    }

    /**
     * Get site
     *
     * @return JLM\ModelBundle\Entity\Site 
     */
    public function getSite()
    {
        return $this->site;
    }

//    /**
//     * Add contracts
//     *
//     * @param JLM\ModelBundle\Entity\Contract $contracts
//     * @return Door
//     */
//    public function addContract(\JLM\ModelBundle\Entity\Contract $contracts)
//    {
//        $this->contracts[] = $contracts;
//    
//        return $this;
//    }
//
//    /**
//     * Remove contracts
//     *
//     * @param JLM\ModelBundle\Entity\Contract $contracts
//     */
//    public function removeContract(\JLM\ModelBundle\Entity\Contract $contracts)
//    {
//        $this->contracts->removeElement($contracts);
//    }
//
//    /**
//     * Get contracts
//     *
//     * @return Doctrine\Common\Collections\Collection 
//     */
//    public function getContracts()
//    {
//        return $this->contracts;
//    }

    /**
     * Set type
     *
     * @param JLM\ModelBundle\Entity\DoorType $type
     * @return Door
     */
    public function setType(\JLM\ModelBundle\Entity\DoorType $type = null)
    {
        $this->type = $type;
    
        return $this;
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
     * @return Door
     */
    public function addPart(\JLM\ModelBundle\Entity\Product $parts)
    {
        $this->parts[] = $parts;
    
        return $this;
    }

    /**
     * Remove parts
     *
     * @param JLM\ModelBundle\Entity\Product $parts
     */
    public function removePart(\JLM\ModelBundle\Entity\Product $parts)
    {
        $this->parts->removeElement($parts);
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
     * Add transmitters
     *
     * @param JLM\ModelBundle\Entity\Product $transmitters
     * @return Door
     */
    public function addTransmitter(\JLM\ModelBundle\Entity\Product $transmitters)
    {
        $this->transmitters[] = $transmitters;
    
        return $this;
    }

    /**
     * Remove transmitters
     *
     * @param JLM\ModelBundle\Entity\Product $transmitters
     */
    public function removeTransmitter(\JLM\ModelBundle\Entity\Product $transmitters)
    {
        $this->transmitters->removeElement($transmitters);
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
     * @return Door
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
     * To String
     */
    public function __toString()
    {
    	return $this->getLocation().'
'.$this->getSite();
    }
}