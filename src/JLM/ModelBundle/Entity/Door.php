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
     * @var TransmitterType $transmitters
     * 
     * @ORM\ManyToMany(targetEntity="TransmitterType")
     * @ORM\JoinTable(name="doors_transmitters",
     * 		joinColumns={@ORM\JoinColumn(name="door_id", referencedColumnName="id")},
     * 		inverseJoinColumns={@ORM\JoinColumn(name="transmitters_id", referencedColumnName="id")}
     * 		)
     */
    private $transmitters;
    
    /**
     * @var string $observations
     *
     * @ORM\Column(name="observations", type="text", nullable=true)
     */
    private $observations;
    
    /**
     * @var string Google Maps (Street)
     * 
     * @ORM\Column(name="googlemaps", type="text", nullable=true)
     */
    private $googlemaps;
    
    /**
     * @var int largeur en mm
     * 
     * @ORM\Column(name="width", type="integer", nullable=true)
     */
    private $width;
    
    /**
     * @var int hauteur en mm
     *
     * @ORM\Column(name="height", type="integer", nullable=true)
     */
    private $height;
    
    /**
     * Porte à l'arrêt
     * @var bool $stoped
     * 
     * @ORM\Column(name="stopped", type="boolean")
     */
    private $stopped = false;
    
    /**
     * Prélibellé de factration
     * @var string $billingPrelabel
     * 
     * @ORM\Column(name="billing_prelabel", type="text", nullable=true)
     */
    private $billingPrelabel;
    
    /**
     * Contrats
     * @var Contract $contracts
     * 
     * @ORM\OneToMany(targetEntity="Contract",mappedBy="door")
     */
    private $contracts;
    
    /**
     * Interventions
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="JLM\DailyBundle\Entity\Intervention",mappedBy="door")
     * @ORM\OrderBy({"creation" = "DESC"})
     */
    private $interventions;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->parts = new ArrayCollection;
    	$this->transmitters = new ArrayCollection;
    	$this->contracts = new ArrayCollection;
    	$this->interventions = new ArrayCollection;
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
     * Set observations
     *
     * @param string $observations
     * @return Door
     */
    public function setObservations($observations)
    {
    	$this->observations = $observations;
    
    	return $this;
    }
    
    /**
     * Get observations
     *
     * @return string
     */
    public function getObservations()
    {
    	return $this->observations;
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
     * Add contract
     *
     * @param JLM\ModelBundle\Entity\Contract $contract
     * @return Door
     */
    public function addContract(\JLM\ModelBundle\Entity\Contract $contract)
    {
    	$this->contracts[] = $contract;
    	
    	return $this;
    }
    
    /**
     * Remove contract
     *
     * @param JLM\ModelBundle\Entity\Contract $contract
     */
    public function removeContract(\JLM\ModelBundle\Entity\Contract $contract)
    {
    	$this->contracts->removeElement($contract);
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
     * Add intervention
     *
     * @param JLM\DailyBundle\Entity\Intervention $interventions
     * @return Door
     */
    public function addIntervention(\JLM\DailyBundle\Entity\Intervention $intervention)
    {
    	$this->interventions[] = $intervention;
    
    	return $this;
    }
    
    /**
     * Remove intervention
     *
     * @param JLM\DailyBundle\Entity\Intervention $interventions
     */
    public function removeIntervention(\JLM\DailyBundle\Entity\Intervention $intervention)
    {
    	$this->interventions->removeElement($intervention);
    }
    
    /**
     * Get interventions
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getInterventions()
    {
    	return $this->interventions;
    }
    
    /**
     * Get actual(s) contracts
     * 
     * @return JLM\ModelBundle\Entity\Contract
     */
    public function getActualContract()
    {
    	$today = new \DateTime;
    	foreach ($this->contracts as $contract)
    	{
    		if ($contract->getInProgress())
    			return $contract;
    	}
    	return null;
    }
    
    /**
     * Add transmitters
     *
     * @param JLM\ModelBundle\Entity\TransmitterType $transmitters
     * @return Door
     */
    public function addTransmitter(TransmitterType $transmitters)
    {
        $this->transmitters[] = $transmitters;
    
        return $this;
    }

    /**
     * Remove transmitters
     *
     * @param JLM\ModelBundle\Entity\TransmitterType $transmitters
     */
    public function removeTransmitter(TransmitterType $transmitters)
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
     * Set largeur
     * 
     * @param int $width
     */
    public function setWidth($width)
    {
    	$this->width = $width;
    	return $this;
    }
    
    /**
     * Get largeur
     * 
     * @return int $width
     */
    public function getWidth()
    {
    	return $this->width;
    }
    
    /**
     * Set hauteur
     *
     * @param int $height
     */
    public function setHeight($height)
    {
    	$this->height = $height;
    	return $this;
    }
    
    /**
     * Get hauteur
     *
     * @return int $height
     */
    public function getHeight()
    {
    	return $this->height;
    }
    
    /**
     * Get stopped
     * 
     * @return bool $stopped
     */
    public function getStopped()
    {
    	return $this->stopped;
    }
    
    /**
     * Is stopped
     * 
     * @return bool $stopped
     */
    public function isStopped()
    {
    	return $ths->getStopped();
    }
    
    /**
     * Set stopped
     * 
     * @param bool $stopped
     */
    public function setStopped($stopped = true)
    {
    	$this->stopped = (bool)$stopped;
    	return $this;
    }
    
    /**
     * Get waitMaintenance
     * 
     * @return bool
     */
    public function getWaitMaintenance()
    {
    	foreach($this->interventions as $interv)
    		if ($interv instanceof \JLM\DailyBundle\Entity\Maintenance)
    			if (!$interv->getClosed())
       				if (!sizeof($interv->getShiftTechnicians()))
    					return true;
		return false;
    }
    
    /**
     * Get WorkInProgress
     */
    public function getWorkInProgress()
    {
    	foreach($this->interventions as $interv)
    		if ($interv instanceof \JLM\DailyBundle\Entity\Work)
    			if (!$interv->getClosed())
    				if (sizeof($interv->getShiftTechnicians()))
    					return true;
    	return false;
    }
    
    /**
     * Get waitWork
     */
    public function getWaitWork()
    {
    	foreach($this->interventions as $interv)
    		if ($interv instanceof \JLM\DailyBundle\Entity\Work)
    			if (!$interv->getClosed())
    				if (!sizeof($interv->getShiftTechnicians()))
    					return true;
    	return false;
    }
    
    /**
     * Get FixingInProgress
     */
    public function getFixingInProgress()
    {
    	foreach($this->interventions as $interv)
    		if ($interv instanceof \JLM\DailyBundle\Entity\Fixing)
    			if (!$interv->getClosed())
    				if (sizeof($interv->getShiftTechnicians()))
    					return true;
    	return false;
    }
    
    /**
     * Get waitFixing
     */
    public function getWaitFixing()
    {
    	foreach($this->interventions as $interv)
    		if ($interv instanceof \JLM\DailyBundle\Entity\Fixing)
    			if (!$interv->getClosed())
    				if (!sizeof($interv->getShiftTechnicians()))
    					return true;
    	return false;
    }
    
    /**
     * Get lastMaintenance
     *
     * @return \DateTime | null
     */
    public function getLastMaintenance()
    {
    	$last = null;
    	foreach($this->interventions as $interv)
    	{
    		if ($interv instanceof \JLM\DailyBundle\Entity\Maintenance)
    		{
    			if ($interv->getClosed())
    			{
    				$shifts = $interv->getShiftTechnicians();
    				$date = null;
    				foreach ($shifts as $shift)
    				{
    					$dateShift = ($shift->getEnd() === null) ? $shift->getBegin() : $shift->getEnd();
    					if ($date === null || $date < $dateShift)
    						$date = $dateShift;
    				}
    				if ($last === null || $last < $date)
    				{
    					$last = $date;
    				}
    			}
    		}
    	}
    	return $last;
    }
    
    /**
     * Get nextMaintenance
     *
     * @return \DateTime | null
     */
    public function getNextMaintenance()
    {
    	$last = null;
    	foreach($this->interventions as $interv)
    	{
    		if ($interv instanceof \JLM\DailyBundle\Entity\Maintenance)
    		{
    			if (!$interv->getClosed())
    			{
    				return $interv;
    			}
    		}
    	}
    	return null;
    }
    
    /**
     * Get billingPrelabel
     * 
     * @return string
     */
    public function getBillingPrelabel()
    {
    	return $this->billingPrelabel;
    }
    
    /**
     * Set billingPrelabel
     * 
     * @param string $label
     * @return Door
     */
    public function setBillingPrelabel($label)
    {
    	$this->billingPrelabel = $label;
    	return $this;
    }
    
    /**
     * To String
     */
    public function __toString()
    {
    	return $this->getLocation().chr(10).$this->getSite();
    }
    
    /**
     * To String
     */
    public function toString()
    {
    	return $this->getType().' - '.$this->getLocation().chr(10).$this->getSite()->toString();
    }
}